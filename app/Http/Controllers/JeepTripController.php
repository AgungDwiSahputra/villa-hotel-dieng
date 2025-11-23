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
        $request->validate([
            'jeep_trip_id' => 'required|uuid|exists:jeep_trips,id',
            'slot_id' => 'required|uuid|exists:jeep_trip_slots,id',
            'tanggal_trip' => 'required|date|after:today',
            'jumlah_jeep' => 'required|integer|min:1',
        ]);

        $jeepTrip = JeepTrip::findOrFail($request->jeep_trip_id);
        $slot = JeepTripSlot::findOrFail($request->slot_id);

        // Validate slot belongs to jeep trip
        if ($slot->jeep_trip_id !== $jeepTrip->id) {
            return back()->withErrors('Slot tidak valid untuk paket jeep trip ini.');
        }

        // Check availability
        $availableUnits = $this->getAvailableUnitsForSlot($slot, $request->tanggal_trip);
        if ($availableUnits < $request->jumlah_jeep) {
            return back()->withErrors('Maaf, unit jeep yang tersedia tidak mencukupi untuk tanggal dan slot yang dipilih.');
        }

        // Calculate pricing (weekday/weekend)
        $tripDate = Carbon::parse($request->tanggal_trip);
        $isWeekend = $tripDate->dayOfWeek === 0 || $tripDate->dayOfWeek === 6;
        $hargaPerJeep = $isWeekend ? $jeepTrip->harga_weekend : $jeepTrip->harga_weekday;
        $totalHarga = $hargaPerJeep * $request->jumlah_jeep;

        // Store booking data in session
        $bookingData = [
            'jeep_trip_id' => $jeepTrip->id,
            'slot_id' => $slot->id,
            'tanggal_trip' => $request->tanggal_trip,
            'jumlah_jeep' => $request->jumlah_jeep,
            'harga_per_jeep' => $hargaPerJeep,
            'total_harga' => $totalHarga,
            'is_weekend' => $isWeekend,
            'slot_info' => [
                'nama_slot' => $slot->nama_slot,
                'jam_mulai' => $slot->jam_mulai,
                'jam_selesai' => $slot->jam_selesai,
            ],
            'trip_info' => [
                'nama_paket' => $jeepTrip->nama_paket,
                'zona' => $jeepTrip->zona,
                'durasi_jam' => $jeepTrip->durasi_jam,
            ]
        ];

        session()->put('jeep_trip_booking', $bookingData);

        return redirect()->route('jeep-trip.checkout');
    }

    /**
     * Display checkout page
     */
    public function checkout()
    {
        if (!session('jeep_trip_booking')) {
            return redirect()->route('jeep-trip.index')->withErrors('Data booking tidak ditemukan.');
        }

        $rekenings = Rekening::orderBy('name')->get();
        $bookingData = session('jeep_trip_booking');
        $jeepTrip = JeepTrip::find($bookingData['jeep_trip_id']);

        return view('landing.jeep-trip.checkout', compact('rekenings', 'jeepTrip', 'bookingData'));
    }

    /**
     * Process final booking with Midtrans integration
     */
    public function final(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_wa' => 'required|string|max:20',
            'payment_method' => 'required|string',
            'total' => 'required|numeric|min:0',
        ]);

        if (!session('jeep_trip_booking')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data booking tidak ditemukan.'
            ], 422);
        }

        $bookingData = session('jeep_trip_booking');
        $jeepTrip = JeepTrip::find($bookingData['jeep_trip_id']);
        $slot = JeepTripSlot::find($bookingData['slot_id']);

        // Validate availability again
        $availableUnits = $this->getAvailableUnitsForSlot($slot, $bookingData['tanggal_trip']);
        if ($availableUnits < $bookingData['jumlah_jeep']) {
            return response()->json([
                'status' => 'error',
                'message' => 'Maaf, unit jeep yang tersedia sudah berubah. Silakan ulangi booking.'
            ], 422);
        }

        // Validate price consistency
        $expectedTotal = $bookingData['total_harga'];
        if (abs($request->total - $expectedTotal) > 0.01) {
            return response()->json([
                'status' => 'error',
                'message' => 'Total harga tidak sesuai. Silakan refresh halaman.'
            ], 422);
        }

        DB::beginTransaction();

        try {
            // Generate order ID
            $orderId = 'JT-' . strtoupper(uniqid());

            // Create booking
            $booking = JeepTripBooking::create([
                'user_id' => auth()->id(),
                'kode_booking' => $orderId,
                'total_harga' => $request->total,
                'status' => 'pending',
                'payment_ref' => $orderId,
            ]);

            // Create booking item
            JeepTripBookingItem::create([
                'jeep_trip_booking_id' => $booking->id,
                'jeep_trip_id' => $jeepTrip->id,
                'jeep_trip_slot_id' => $slot->id,
                'tanggal_trip' => $bookingData['tanggal_trip'],
                'jumlah_jeep' => $bookingData['jumlah_jeep'],
                'harga_satuan' => $bookingData['harga_per_jeep'],
                'subtotal' => $bookingData['total_harga'],
            ]);

            // Update availability
            $availability = JeepTripAvailability::where('jeep_trip_slot_id', $slot->id)
                ->where('tanggal', $bookingData['tanggal_trip'])
                ->first();

            if ($availability) {
                $availability->increment('quota_terpakai', $bookingData['jumlah_jeep']);
            }

            // Prepare Midtrans payment parameters
            $itemDetails = [
                [
                    'id' => $jeepTrip->id,
                    'price' => (int) $request->total,
                    'quantity' => 1,
                    'name' => $jeepTrip->nama_paket . ' - ' . $bookingData['jumlah_jeep'] . ' jeep',
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
                'booking_data' => $bookingData,
                'request_data' => $request->all()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memproses booking: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * Get available units for specific slot and date
     */
    private function getAvailableUnitsForSlot(JeepTripSlot $slot, $date)
    {
        $availability = JeepTripAvailability::where('jeep_trip_slot_id', $slot->id)
            ->where('tanggal', $date)
            ->first();

        if (!$availability || $availability->is_closed) {
            return 0;
        }

        return $availability->quota_jeep - $availability->quota_terpakai;
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