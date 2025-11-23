<?php

namespace App\Http\Controllers;

use App\Models\JeepTrip\JeepTrip;
use App\Models\JeepTrip\JeepTripAvailability;
use App\Models\JeepTrip\JeepTripBooking;
use App\Models\JeepTrip\JeepTripBookingItem;
use App\Models\JeepTrip\JeepTripSlot;
use App\Models\Rekening;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;

class JeepTripController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    /**
     * Display listing of jeep trips
     */
    public function index(Request $request)
    {
        $searchQuery = $request->get('search');
        $zona = $request->get('zona');
        $durasi = $request->get('durasi');
        $sortBy = $request->get('sort', 'rating');

        $jeepTripsQuery = JeepTrip::with('images', 'slots')
            ->where('is_active', true);

        // Apply filters
        if ($searchQuery) {
            $jeepTripsQuery->where(function ($query) use ($searchQuery) {
                $query->where('nama_paket', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('deskripsi_singkat', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('zona', 'LIKE', '%' . $searchQuery . '%');
            });
        }

        if ($zona) {
            $jeepTripsQuery->where('zona', $zona);
        }

        if ($durasi) {
            if ($durasi === '1-2') {
                $jeepTripsQuery->where('durasi_jam', '<=', 2);
            } elseif ($durasi === '3-4') {
                $jeepTripsQuery->whereBetween('durasi_jam', [3, 4]);
            } elseif ($durasi === '5+') {
                $jeepTripsQuery->where('durasi_jam', '>=', 5);
            }
        }

        // Apply sorting
        switch ($sortBy) {
            case 'price-low':
                $jeepTripsQuery->orderBy('harga_weekday', 'asc');
                break;
            case 'price-high':
                $jeepTripsQuery->orderBy('harga_weekday', 'desc');
                break;
            case 'rating':
                $jeepTripsQuery->orderBy('rating', 'desc');
                break;
            case 'name':
                $jeepTripsQuery->orderBy('nama_paket', 'asc');
                break;
            default:
                $jeepTripsQuery->orderBy('rating', 'desc');
        }

        $jeepTrips = $jeepTripsQuery->paginate(12);

        // Get unique zona for filter dropdown
        $zonaList = JeepTrip::where('is_active', true)
            ->distinct()
            ->pluck('zona')
            ->filter()
            ->sort()
            ->values();

        return view('landing.jeep-trip.index', compact('jeepTrips', 'searchQuery', 'zona', 'durasi', 'sortBy', 'zonaList'));
    }

    /**
     * Display detail of specific jeep trip
     */
    public function show($slug)
    {
        $jeepTrip = JeepTrip::with(['images', 'destinations', 'includes', 'excludes', 'slots'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Get recommended jeep trips (other active trips)
        $recommendedTrips = JeepTrip::with('images')
            ->where('id', '!=', $jeepTrip->id)
            ->where('is_active', true)
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return view('landing.jeep-trip.show', compact('jeepTrip', 'recommendedTrips'));
    }

    /**
     * Process jeep trip booking
     */
    public function booking(Request $request)
    {
        Log::info('Jeep Trip Booking Process Started', [
            'request_data' => $request->all(),
            'user_id' => auth()->check() ? auth()->id() : null,
            'ip' => $request->ip()
        ]);

        $request->validate([
            'jeep_trip_id' => 'required|uuid|exists:jeep_trips,id',
            'slot_id' => 'required|uuid|exists:jeep_trip_slots,id',
            'tanggal_trip' => 'required|date|after:today',
            'jumlah_jeep' => 'required|integer|min:1',
        ]);

        $jeepTrip = JeepTrip::findOrFail($request->jeep_trip_id);
        $slot = JeepTripSlot::findOrFail($request->slot_id);

        Log::info('Jeep Trip Booking Validation Passed', [
            'jeep_trip_id' => $jeepTrip->id,
            'slot_id' => $slot->id,
            'tanggal_trip' => $request->tanggal_trip,
            'jumlah_jeep' => $request->jumlah_jeep
        ]);

        // Validate slot belongs to jeep trip
        if ($slot->jeep_trip_id !== $jeepTrip->id) {
            Log::warning('Jeep Trip Booking: Invalid slot for jeep trip', [
                'jeep_trip_id' => $jeepTrip->id,
                'slot_id' => $slot->id,
                'slot_jeep_trip_id' => $slot->jeep_trip_id
            ]);
            return back()->withErrors('Slot tidak valid untuk paket jeep trip ini.');
        }

        // Check availability
        $availableUnits = $this->getAvailableUnitsForSlot($slot, $request->tanggal_trip);
        Log::info('Jeep Trip Booking: Availability Check', [
            'slot_id' => $slot->id,
            'tanggal' => $request->tanggal_trip,
            'available_units' => $availableUnits,
            'requested_units' => $request->jumlah_jeep
        ]);

        if ($availableUnits < $request->jumlah_jeep) {
            Log::warning('Jeep Trip Booking: Insufficient availability', [
                'available' => $availableUnits,
                'requested' => $request->jumlah_jeep,
                'slot_id' => $slot->id,
                'tanggal' => $request->tanggal_trip
            ]);
            return back()->withErrors('Maaf, unit jeep yang tersedia tidak mencukupi untuk tanggal dan slot yang dipilih.');
        }

        // Calculate pricing (weekday/weekend)
        $tripDate = Carbon::parse($request->tanggal_trip);
        $isWeekend = $tripDate->dayOfWeek === 0 || $tripDate->dayOfWeek === 6;
        $hargaPerJeep = $isWeekend ? $jeepTrip->harga_weekend : $jeepTrip->harga_weekday;
        $totalHarga = $hargaPerJeep * $request->jumlah_jeep;

        Log::info('Jeep Trip Booking: Price Calculation', [
            'tanggal' => $request->tanggal_trip,
            'is_weekend' => $isWeekend,
            'harga_per_jeep' => $hargaPerJeep,
            'jumlah_jeep' => $request->jumlah_jeep,
            'total_harga' => $totalHarga
        ]);

        // Create draft booking in database to avoid session dependency
        DB::beginTransaction();

        try {
            $draftBooking = JeepTripBooking::create([
                'user_id' => auth()->id(),
                'kode_booking' => 'DRAFT-' . strtoupper(uniqid()),
                'total_harga' => $totalHarga,
                'status' => 'draft',
            ]);

            // Create draft booking item
            JeepTripBookingItem::create([
                'jeep_trip_booking_id' => $draftBooking->id,
                'jeep_trip_id' => $jeepTrip->id,
                'jeep_trip_slot_id' => $slot->id,
                'tanggal_trip' => $request->tanggal_trip,
                'jumlah_jeep' => $request->jumlah_jeep,
                'harga_satuan' => $hargaPerJeep,
                'subtotal' => $totalHarga,
            ]);

            DB::commit();

            // Store minimal data in session (just booking ID)
            $sessionData = [
                'booking_id' => $draftBooking->id,
                'expires_at' => now()->addMinutes(30)->toISOString(), // 30 minutes expiry
            ];

            session()->put('jeep_trip_booking', $sessionData);

            Log::info('Jeep Trip Booking: Draft booking created successfully', [
                'draft_booking_id' => $draftBooking->id,
                'user_id' => auth()->id(),
                'jeep_trip_id' => $jeepTrip->id,
                'total_harga' => $totalHarga
            ]);

            return redirect()->route('jeep-trip.checkout');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Jeep Trip Booking: Failed to create draft booking', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'jeep_trip_id' => $jeepTrip->id
            ]);

            return back()->withErrors('Terjadi kesalahan saat memproses booking. Silakan coba lagi.');
        }
    }

    /**
     * Display checkout page
     */
    public function checkout()
    {
        if (!session('jeep_trip_booking') || !isset(session('jeep_trip_booking')['booking_id'])) {
            return redirect()->route('jeep-trip.index')->withErrors('Data booking tidak ditemukan.');
        }

        $sessionData = session('jeep_trip_booking');

        // Check if draft booking has expired
        if (isset($sessionData['expires_at']) && now()->isAfter($sessionData['expires_at'])) {
            // Clean up expired draft booking
            $expiredBooking = JeepTripBooking::find($sessionData['booking_id']);
            if ($expiredBooking && $expiredBooking->status === 'draft') {
                $expiredBooking->update(['status' => 'expired']);
            }
            session()->forget('jeep_trip_booking');
            return redirect()->route('jeep-trip.index')->withErrors('Sesi booking telah kedaluwarsa. Silakan mulai booking dari awal.');
        }

        // Load draft booking from database
        $draftBooking = JeepTripBooking::with('bookingItems.jeepTrip', 'bookingItems.slot')
            ->where('id', $sessionData['booking_id'])
            ->where('status', 'draft')
            ->where('user_id', auth()->id())
            ->first();

        if (!$draftBooking || !$draftBooking->bookingItems->count()) {
            session()->forget('jeep_trip_booking');
            return redirect()->route('jeep-trip.index')->withErrors('Data booking tidak valid.');
        }

        $bookingItem = $draftBooking->bookingItems->first();
        $jeepTrip = $bookingItem->jeepTrip;

        // Prepare booking data for view
        $bookingData = [
            'jeep_trip_id' => $jeepTrip->id,
            'slot_id' => $bookingItem->jeep_trip_slot_id,
            'tanggal_trip' => $bookingItem->tanggal_trip->format('Y-m-d'),
            'jumlah_jeep' => $bookingItem->jumlah_jeep,
            'harga_per_jeep' => $bookingItem->harga_satuan,
            'total_harga' => $bookingItem->subtotal,
            'is_weekend' => $this->isWeekendDate($bookingItem->tanggal_trip),
            'slot_info' => [
                'nama_slot' => $bookingItem->slot->nama_slot,
                'jam_mulai' => $bookingItem->slot->jam_mulai,
                'jam_selesai' => $bookingItem->slot->jam_selesai,
            ],
            'trip_info' => [
                'nama_paket' => $jeepTrip->nama_paket,
                'zona' => $jeepTrip->zona,
                'durasi_jam' => $jeepTrip->durasi_jam,
            ]
        ];

        $rekenings = Rekening::orderBy('name')->get();

        return view('landing.jeep-trip.checkout', compact('rekenings', 'jeepTrip', 'bookingData'));
    }

    /**
     * Process final booking with Midtrans integration
     */
    public function final(Request $request)
    {
        Log::info('Jeep Trip Final Booking Process Started', [
            'request_data' => $request->all(),
            'user_id' => auth()->check() ? auth()->id() : null,
            'session_has_booking' => session()->has('jeep_trip_booking'),
            'ip' => $request->ip()
        ]);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_wa' => 'required|string|max:20',
            'payment_method' => 'required|string',
            'total' => 'required|numeric|min:0',
        ]);

        if (!session('jeep_trip_booking') || !isset(session('jeep_trip_booking')['booking_id'])) {
            Log::error('Jeep Trip Final Booking: No booking data in session');
            return response()->json([
                'status' => 'error',
                'message' => 'Data booking tidak ditemukan.'
            ], 422);
        }

        $sessionData = session('jeep_trip_booking');

        // Load draft booking from database
        $draftBooking = JeepTripBooking::with('bookingItems.jeepTrip', 'bookingItems.slot')
            ->where('id', $sessionData['booking_id'])
            ->where('status', 'draft')
            ->where('user_id', auth()->id())
            ->first();

        if (!$draftBooking || !$draftBooking->bookingItems->count()) {
            Log::error('Jeep Trip Final Booking: Draft booking not found or invalid', [
                'booking_id' => $sessionData['booking_id'],
                'user_id' => auth()->id()
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Data booking tidak valid.'
            ], 422);
        }

        $bookingItem = $draftBooking->bookingItems->first();
        $jeepTrip = $bookingItem->jeepTrip;
        $slot = $bookingItem->slot;

        Log::info('Jeep Trip Final Booking: Draft booking loaded', [
            'booking_id' => $draftBooking->id,
            'jeep_trip_id' => $jeepTrip->id,
            'slot_id' => $slot->id,
            'total_harga' => $draftBooking->total_harga
        ]);

        // Validate availability again with pessimistic locking to prevent race conditions
        DB::beginTransaction();

        try {
            $availableUnits = $this->getAvailableUnitsForSlot($slot, $bookingItem->tanggal_trip->format('Y-m-d'), true); // Use lock
            Log::info('Jeep Trip Final Booking: Final availability check with lock', [
                'available_units' => $availableUnits,
                'requested_units' => $bookingItem->jumlah_jeep,
                'slot_id' => $slot->id,
                'tanggal' => $bookingItem->tanggal_trip->format('Y-m-d')
            ]);

            if ($availableUnits < $bookingItem->jumlah_jeep) {
                DB::rollBack();
                Log::warning('Jeep Trip Final Booking: Insufficient availability on final check', [
                    'available' => $availableUnits,
                    'requested' => $bookingItem->jumlah_jeep
                ]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Maaf, unit jeep yang tersedia sudah berubah. Silakan ulangi booking.'
                ], 422);
            }

            // Validate price consistency
            $expectedTotal = $draftBooking->total_harga;
            $priceDifference = abs($request->total - $expectedTotal);
            Log::info('Jeep Trip Final Booking: Price validation', [
                'expected_total' => $expectedTotal,
                'request_total' => $request->total,
                'difference' => $priceDifference,
                'threshold' => 0.01
            ]);

            if ($priceDifference > 0.01) {
                DB::rollBack();
                Log::warning('Jeep Trip Final Booking: Price inconsistency detected', [
                    'expected' => $expectedTotal,
                    'received' => $request->total,
                    'difference' => $priceDifference
                ]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Total harga tidak sesuai. Silakan refresh halaman.'
                ], 422);
            }

            Log::info('Jeep Trip Final Booking: All validations passed, proceeding with booking creation');

            // Generate order ID
            $orderId = 'JT-' . strtoupper(uniqid());

            // Update draft booking to pending
            $draftBooking->update([
                'kode_booking' => $orderId,
                'status' => 'pending',
                'payment_ref' => $orderId,
            ]);

            // Update availability (already locked)
            $availability = JeepTripAvailability::where('jeep_trip_slot_id', $slot->id)
                ->where('tanggal', $bookingItem->tanggal_trip->format('Y-m-d'))
                ->lockForUpdate()
                ->first();

            if ($availability) {
                $availability->increment('quota_terpakai', $bookingItem->jumlah_jeep);
                Log::info('Jeep Trip Availability Updated', [
                    'slot_id' => $slot->id,
                    'tanggal' => $bookingItem->tanggal_trip->format('Y-m-d'),
                    'quota_terpakai_before' => $availability->quota_terpakai - $bookingItem->jumlah_jeep,
                    'quota_terpakai_after' => $availability->quota_terpakai,
                    'increment_amount' => $bookingItem->jumlah_jeep
                ]);
            }

            // Prepare Midtrans payment parameters
            $itemDetails = [
                [
                    'id' => $jeepTrip->id,
                    'price' => (int) $request->total,
                    'quantity' => 1,
                    'name' => $jeepTrip->nama_paket . ' - ' . $bookingItem->jumlah_jeep . ' jeep',
                ],
            ];

            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => (int) $request->total,
                ],
                'customer_details' => [
                    'first_name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->no_wa,
                ],
                'item_details' => $itemDetails,
                'enabled_payments' => ['gopay', 'bank_transfer'],
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($params);

            DB::commit();

            // Log successful booking creation
            Log::info('Jeep Trip Booking Created', [
                'order_id' => $orderId,
                'jeep_trip_id' => $jeepTrip->id,
                'user_id' => auth()->id(),
                'total' => $request->total
            ]);

            // Clear session
            session()->forget('jeep_trip_booking');

            return response()->json([
                'status' => 'success',
                'snap_token' => $snapToken,
                'order_id' => $orderId,
                'message' => 'Booking Jeep Trip berhasil dibuat, silakan lakukan pembayaran'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Jeep Trip Booking Error: ' . $e->getMessage(), [
                'draft_booking_id' => $draftBooking->id,
                'request_data' => $request->all()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memproses booking: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * Get available units for specific slot and date with pessimistic locking
     */
    private function getAvailableUnitsForSlot(JeepTripSlot $slot, $date, $useLock = false)
    {
        Log::info('Jeep Trip Availability Check Started', [
            'slot_id' => $slot->id,
            'slot_name' => $slot->nama_slot,
            'tanggal' => $date,
            'jeep_trip_id' => $slot->jeep_trip_id,
            'use_lock' => $useLock
        ]);

        $query = JeepTripAvailability::where('jeep_trip_slot_id', $slot->id)
            ->where('tanggal', $date);

        // Use pessimistic locking for critical operations to prevent race conditions
        if ($useLock) {
            $availability = $query->lockForUpdate()->first();
        } else {
            $availability = $query->first();
        }

        if (!$availability) {
            Log::info('Jeep Trip Availability: No availability record found', [
                'slot_id' => $slot->id,
                'tanggal' => $date,
                'action' => 'returning 0 (no record)'
            ]);
            return 0;
        }

        if ($availability->is_closed) {
            Log::info('Jeep Trip Availability: Slot is closed', [
                'slot_id' => $slot->id,
                'tanggal' => $date,
                'is_closed' => $availability->is_closed,
                'action' => 'returning 0 (closed)'
            ]);
            return 0;
        }

        $availableUnits = $availability->quota_jeep - $availability->quota_terpakai;

        Log::info('Jeep Trip Availability: Calculation completed', [
            'slot_id' => $slot->id,
            'tanggal' => $date,
            'quota_total' => $availability->quota_jeep,
            'quota_terpakai' => $availability->quota_terpakai,
            'available_units' => $availableUnits,
            'locked' => $useLock
        ]);

        return max(0, $availableUnits); // Ensure non-negative
    }

    /**
     * Handle Midtrans payment callback for Jeep Trip bookings
     */
    public function handleCallback(Request $request)
    {
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');

        $notification = new \Midtrans\Notification();

        $orderId = $notification->order_id;
        $transactionStatus = $notification->transaction_status;
        $fraudStatus = $notification->fraud_status;
        $signatureKey = $notification->signature_key;

        $localSignatureKey = hash('sha512', $orderId . $notification->status_code . $notification->gross_amount . config('midtrans.server_key'));

        if ($signatureKey !== $localSignatureKey) {
            Log::warning('Midtrans notification signature mismatch for Jeep Trip.', ['order_id' => $orderId]);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $booking = JeepTripBooking::where('kode_booking', $orderId)->first();

        if (!$booking) {
            Log::error('Jeep Trip booking not found for order_id:', ['order_id' => $orderId]);
            return response()->json(['message' => 'Booking not found'], 404);
        }

        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'accept') {
                $booking->status = 'paid';
            }
        } else if ($transactionStatus == 'settlement') {
            $booking->status = 'paid';
        } else if ($transactionStatus == 'pending') {
            $booking->status = 'pending';
        } else if ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
            $booking->status = 'cancelled';

            // Restore availability if payment failed
            $bookingItem = $booking->bookingItems()->first();
            if ($bookingItem) {
                $availability = JeepTripAvailability::where('jeep_trip_slot_id', $bookingItem->jeep_trip_slot_id)
                    ->where('tanggal', $bookingItem->tanggal_trip)
                    ->first();

                if ($availability) {
                    $availability->decrement('quota_terpakai', $bookingItem->jumlah_jeep);
                }
            }
        }

        $booking->save();

        // TODO: Send email notifications on successful payment
        if ($booking->status === 'paid') {
            try {
                // Load booking with relationships for email template
                $booking->load('user', 'bookingItems.jeepTrip', 'bookingItems.jeepTripSlot');

                // Send payment success notification
                // You can create email classes similar to InvoiceNotification
                Log::info('Jeep Trip payment successful.', ['order_id' => $orderId, 'booking_id' => $booking->id]);

            } catch (\Exception $e) {
                Log::error('Failed to send Jeep Trip payment notification emails.', [
                    'order_id' => $orderId,
                    'error' => $e->getMessage()
                ]);
            }
        }

        Log::info('Jeep Trip Midtrans notification processed successfully.', [
            'order_id' => $orderId,
            'status' => $booking->status
        ]);

        return response()->json(['message' => 'Notification processed successfully'], 200);
    }

    /**
     * Check if a date is weekend
     */
    private function isWeekendDate($date)
    {
        $dayOfWeek = \Carbon\Carbon::parse($date)->dayOfWeek;
        return ($dayOfWeek === 0 || $dayOfWeek === 6); // Sunday = 0, Saturday = 6
    }

    /**
     * Get availability status text
     */
    private function getAvailabilityStatus($available, $total)
    {
        if ($available <= 0) {
            return 'penuh';
        } elseif ($available <= 2) {
            return 'hampir_penuh';
        } else {
            return 'tersedia';
        }
    }
}