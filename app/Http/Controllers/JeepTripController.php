<?php

namespace App\Http\Controllers;

use App\Models\JeepTrip\JeepTrip;
use App\Models\JeepTrip\JeepTripAvailability;
use App\Models\JeepTrip\JeepTripBooking;
use App\Models\JeepTrip\JeepTripBookingItem;
use App\Models\JeepTrip\JeepTripSlot;
use App\Models\Rekening;
use App\Models\Setting;
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
            'user_authenticated' => auth()->check(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        // Allow booking without authentication (similar to villa booking)

        $request->validate([
            'jeep_trip_id' => 'required|uuid|exists:jeep_trips,id',
            'slot_id' => 'required|uuid|exists:jeep_trip_slots,id',
            'tanggal_trip' => 'required|date|after:today',
            'jumlah_jeep' => 'required|integer|min:1',
        ]);

        Log::info('Jeep Trip Booking: Validation rules passed');

        try {
            $jeepTrip = JeepTrip::findOrFail($request->jeep_trip_id);
            $slot = JeepTripSlot::findOrFail($request->slot_id);

            Log::info('Jeep Trip Booking: Models loaded successfully', [
                'jeep_trip_id' => $jeepTrip->id,
                'jeep_trip_name' => $jeepTrip->nama_paket,
                'slot_id' => $slot->id,
                'slot_name' => $slot->nama_slot,
                'tanggal_trip' => $request->tanggal_trip,
                'jumlah_jeep' => $request->jumlah_jeep
            ]);
        } catch (\Exception $e) {
            Log::error('Jeep Trip Booking: Failed to load models', [
                'error' => $e->getMessage(),
                'jeep_trip_id' => $request->jeep_trip_id,
                'slot_id' => $request->slot_id
            ]);
            return back()->withErrors('Data jeep trip atau slot tidak ditemukan.');
        }

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

            // Calculate DP consistently
            $dpPercentage = $this->getDpPercentage();
            $dpAmount = round($totalHarga * ($dpPercentage / 100), 2); // Round to 2 decimal places

            // Store booking data with DP info in session
            $sessionData = [
                'booking_id' => $draftBooking->id,
                'dp_percentage' => $dpPercentage,
                'dp_amount' => $dpAmount,
                'total_harga' => $totalHarga,
                'expires_at' => now()->addMinutes(30)->toISOString(), // 30 minutes expiry
            ];

            session()->put('jeep_trip_booking', $sessionData);

            Log::info('Jeep Trip Booking: Draft booking created successfully', [
                'draft_booking_id' => $draftBooking->id,
                'user_id' => auth()->id(),
                'jeep_trip_id' => $jeepTrip->id,
                'total_harga' => $totalHarga,
                'session_data' => $sessionData
            ]);

            return redirect()->route('jeep-trip.checkout');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Jeep Trip Booking: Failed to create draft booking', [
                'error' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'user_id' => auth()->id(),
                'jeep_trip_id' => $jeepTrip->id,
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withErrors('Terjadi kesalahan saat memproses booking. Silakan coba lagi.');
        }
    }

    /**
     * Display checkout page
     */
    public function checkout()
    {
        Log::info('Jeep Trip Checkout Page Access', [
            'user_id' => auth()->check() ? auth()->id() : null,
            'user_email' => auth()->check() ? auth()->user()->email : null,
            'session_has_booking' => session()->has('jeep_trip_booking'),
            'session_data' => session('jeep_trip_booking'),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);

        if (!session('jeep_trip_booking') || !isset(session('jeep_trip_booking')['booking_id'])) {
            Log::warning('Jeep Trip Checkout: No booking data in session', [
                'session_all' => session()->all(),
                'user_id' => auth()->check() ? auth()->id() : null
            ]);
            return redirect()->route('jeep-trip.index')->withErrors('Data booking tidak ditemukan.');
        }

        $sessionData = session('jeep_trip_booking');
        Log::info('Jeep Trip Checkout: Session data found', [
            'session_booking_id' => $sessionData['booking_id'] ?? null,
            'session_expires_at' => $sessionData['expires_at'] ?? null,
            'current_time' => now()->toISOString()
        ]);

        // Check if draft booking has expired
        if (isset($sessionData['expires_at']) && now()->isAfter($sessionData['expires_at'])) {
            Log::warning('Jeep Trip Checkout: Draft booking expired', [
                'booking_id' => $sessionData['booking_id'],
                'expires_at' => $sessionData['expires_at'],
                'current_time' => now()->toISOString()
            ]);

            // Clean up expired draft booking
            $expiredBooking = JeepTripBooking::find($sessionData['booking_id']);
            if ($expiredBooking && $expiredBooking->status === 'draft') {
                $expiredBooking->update(['status' => 'expired']);
                Log::info('Jeep Trip Checkout: Expired draft booking cleaned up', [
                    'booking_id' => $expiredBooking->id
                ]);
            }
            session()->forget('jeep_trip_booking');
            return redirect()->route('jeep-trip.index')->withErrors('Sesi booking telah kedaluwarsa. Silakan mulai booking dari awal.');
        }

        // Load draft booking from database (allow booking without user login)
        $draftBooking = JeepTripBooking::with('bookingItems.jeepTrip', 'bookingItems.slot')
            ->where('id', $sessionData['booking_id'])
            ->where('status', 'draft')
            ->first();

        Log::info('Jeep Trip Checkout: Database query result', [
            'booking_found' => $draftBooking ? true : false,
            'booking_id' => $draftBooking ? $draftBooking->id : null,
            'booking_status' => $draftBooking ? $draftBooking->status : null,
            'booking_user_id' => $draftBooking ? $draftBooking->user_id : null,
            'current_user_id' => auth()->id(),
            'booking_items_count' => $draftBooking ? $draftBooking->bookingItems->count() : 0
        ]);

        if (!$draftBooking || !$draftBooking->bookingItems->count()) {
            Log::error('Jeep Trip Checkout: Draft booking not found or invalid', [
                'session_booking_id' => $sessionData['booking_id'],
                'user_id' => auth()->id(),
                'booking_exists' => JeepTripBooking::find($sessionData['booking_id']) ? true : false
            ]);
            session()->forget('jeep_trip_booking');
            return redirect()->route('jeep-trip.index')->withErrors('Data booking tidak valid.');
        }

        // Validate consistency between session and database data
        $bookingItem = $draftBooking->bookingItems->first();
        $dbTotalHarga = $bookingItem->subtotal;
        $sessionTotalHarga = $sessionData['total_harga'] ?? null;

        if ($sessionTotalHarga && abs($dbTotalHarga - $sessionTotalHarga) > 0.01) {
            Log::warning('Jeep Trip Checkout: Data inconsistency detected between session and database', [
                'session_total' => $sessionTotalHarga,
                'db_total' => $dbTotalHarga,
                'difference' => abs($dbTotalHarga - $sessionTotalHarga),
                'booking_id' => $draftBooking->id
            ]);
            // Update session with correct data from database
            $sessionData['total_harga'] = $dbTotalHarga;
            $sessionData['dp_amount'] = round($dbTotalHarga * (($sessionData['dp_percentage'] ?? 50) / 100), 2);
            session()->put('jeep_trip_booking', $sessionData);
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

        // Use DP data from session if available, otherwise calculate
        if ($sessionData && isset($sessionData['dp_percentage']) && isset($sessionData['dp_amount'])) {
            $dpPercentage = $sessionData['dp_percentage'];
            $dpAmount = $sessionData['dp_amount'];
            Log::info('Jeep Trip Checkout: Using DP from session', [
                'dp_percentage' => $dpPercentage,
                'dp_amount' => $dpAmount
            ]);
        } else {
            $dpPercentage = $this->getDpPercentage();
            $dpAmount = round($bookingData['total_harga'] * ($dpPercentage / 100), 2);
            Log::info('Jeep Trip Checkout: Calculating DP (session data not found)', [
                'dp_percentage' => $dpPercentage,
                'dp_amount' => $dpAmount
            ]);
        }

        Log::info('Jeep Trip Checkout: View data prepared', [
            'jeep_trip_id' => $jeepTrip->id,
            'jeep_trip_name' => $jeepTrip->nama_paket,
            'booking_data_keys' => array_keys($bookingData),
            'booking_total_harga' => $bookingData['total_harga'] ?? null,
            'dp_percentage' => $dpPercentage,
            'dp_amount' => $dpAmount,
            'session_will_be_cleared' => false
        ]);

        return view('landing.jeep-trip.checkout', compact('jeepTrip', 'bookingData', 'dpPercentage', 'dpAmount'));
    }

    /**
     * Process final booking with Midtrans integration
     */
    public function final(Request $request)
    {
        Log::info('Jeep Trip Final Booking Process Started', [
            'request_data' => $request->all(),
            'user_id' => auth()->check() ? auth()->id() : null,
            'user_email' => auth()->check() ? auth()->user()->email : null,
            'session_has_booking' => session()->has('jeep_trip_booking'),
            'session_data' => session('jeep_trip_booking'),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'csrf_token_provided' => $request->has('_token'),
            'csrf_token_valid' => $request->_token === csrf_token()
        ]);

        // Validate CSRF token
        if (!$request->has('_token') || $request->_token !== csrf_token()) {
            Log::warning('Jeep Trip Final Booking: Invalid CSRF token', [
                'has_token' => $request->has('_token'),
                'token_valid' => $request->has('_token') ? ($request->_token === csrf_token()) : false,
                'user_id' => auth()->check() ? auth()->id() : null,
                'ip' => $request->ip()
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Sesi tidak valid. Silakan refresh halaman.'
            ], 419); // CSRF token mismatch status
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_wa' => 'required|string|max:20',
            'total' => 'required|numeric|min:0',
        ]);

        Log::info('Jeep Trip Final Booking: Validation passed', [
            'name' => $request->name,
            'email' => $request->email,
            'total' => $request->total
        ]);

        if (!session('jeep_trip_booking') || !isset(session('jeep_trip_booking')['booking_id'])) {
            Log::error('Jeep Trip Final Booking: No booking data in session', [
                'session_all' => session()->all(),
                'user_id' => auth()->check() ? auth()->id() : null
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Data booking tidak ditemukan.'
            ], 422);
        }

        $sessionData = session('jeep_trip_booking');

        // Validate session integrity
        $sessionValidationErrors = [];
        if (!isset($sessionData['dp_amount']) || !is_numeric($sessionData['dp_amount'])) {
            $sessionValidationErrors[] = 'DP amount missing or invalid';
        }
        if (!isset($sessionData['dp_percentage']) || !is_numeric($sessionData['dp_percentage'])) {
            $sessionValidationErrors[] = 'DP percentage missing or invalid';
        }
        if (!isset($sessionData['total_harga']) || !is_numeric($sessionData['total_harga'])) {
            $sessionValidationErrors[] = 'Total harga missing or invalid';
        }
        if (!isset($sessionData['expires_at'])) {
            $sessionValidationErrors[] = 'Session expiry missing';
        } elseif (now()->isAfter($sessionData['expires_at'])) {
            $sessionValidationErrors[] = 'Session expired';
        }

        if (!empty($sessionValidationErrors)) {
            Log::error('Jeep Trip Final Booking: Session data integrity validation failed', [
                'session_data' => $sessionData,
                'validation_errors' => $sessionValidationErrors,
                'user_id' => auth()->check() ? auth()->id() : null,
                'current_time' => now()->toISOString()
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Sesi booking tidak valid. Silakan mulai ulang proses booking.',
                'errors' => $sessionValidationErrors
            ], 422);
        }

        // Load draft booking from database (allow booking without user login)
        $draftBooking = JeepTripBooking::with('bookingItems.jeepTrip', 'bookingItems.slot')
            ->where('id', $sessionData['booking_id'])
            ->where('status', 'draft')
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

        // Begin transaction for atomic operations
        DB::beginTransaction();

        try {

            // Validate DP amount consistency using session data
            $sessionData = session('jeep_trip_booking');
            if (!$sessionData || !isset($sessionData['dp_amount'])) {
                DB::rollBack();
                Log::error('Jeep Trip Final Booking: DP data not found in session', [
                    'session_data' => $sessionData
                ]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data DP tidak ditemukan. Silakan mulai ulang proses booking.'
                ], 422);
            }

            $expectedDpAmount = $sessionData['dp_amount'];
            $priceDifference = abs($request->total - $expectedDpAmount);
            Log::info('Jeep Trip Final Booking: DP validation using session data', [
                'session_dp_amount' => $expectedDpAmount,
                'session_dp_percentage' => $sessionData['dp_percentage'] ?? null,
                'request_total' => $request->total,
                'difference' => $priceDifference,
                'threshold' => 0.01
            ]);

            if ($priceDifference > 0.01) {
                DB::rollBack();

                // Detailed logging for debugging
                Log::warning('Jeep Trip Final Booking: DP amount inconsistency detected', [
                    'expected_dp' => $expectedDpAmount,
                    'received' => $request->total,
                    'difference' => $priceDifference,
                    'threshold' => 0.01,
                    'session_data' => $sessionData,
                    'draft_booking_id' => $draftBooking->id,
                    'draft_booking_total' => $draftBooking->total_harga,
                    'user_id' => auth()->id(),
                    'user_ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'request_all' => $request->all(),
                    'csrf_token_valid' => $request->_token === csrf_token(),
                    'current_time' => now()->toISOString(),
                    'session_expires_at' => $sessionData['expires_at'] ?? null,
                    'time_since_booking' => isset($sessionData['expires_at']) ?
                        now()->diffInMinutes(\Carbon\Carbon::parse($sessionData['expires_at'])->subMinutes(30)) : null
                ]);

                return response()->json([
                    'status' => 'error',
                    'message' => 'Jumlah DP tidak sesuai. Silakan refresh halaman atau mulai ulang booking.'
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

            // Update availability with atomic operation to prevent race conditions
            $availabilityUpdated = JeepTripAvailability::where('jeep_trip_slot_id', $slot->id)
                ->where('tanggal', $bookingItem->tanggal_trip->format('Y-m-d'))
                ->where('is_closed', false)
                ->whereRaw('quota_jeep - quota_terpakai >= ?', [$bookingItem->jumlah_jeep])
                ->increment('quota_terpakai', $bookingItem->jumlah_jeep);

            if ($availabilityUpdated === 0) {
                // No rows were updated, meaning availability check failed
                DB::rollBack();
                Log::warning('Jeep Trip Final Booking: Atomic availability update failed', [
                    'slot_id' => $slot->id,
                    'tanggal' => $bookingItem->tanggal_trip->format('Y-m-d'),
                    'requested_jeep' => $bookingItem->jumlah_jeep,
                    'availability_updated' => $availabilityUpdated
                ]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Maaf, unit jeep yang tersedia sudah berubah. Silakan ulangi booking.'
                ], 422);
            }

            Log::info('Jeep Trip Availability Updated Atomically', [
                'slot_id' => $slot->id,
                'tanggal' => $bookingItem->tanggal_trip->format('Y-m-d'),
                'increment_amount' => $bookingItem->jumlah_jeep,
                'rows_affected' => $availabilityUpdated
            ]);

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

            Log::info('Jeep Trip Final Booking: Midtrans parameters prepared', [
                'order_id' => $orderId,
                'gross_amount' => (int) $request->total,
                'customer_name' => $request->name,
                'customer_email' => $request->email,
                'customer_phone' => $request->no_wa,
                'item_count' => count($itemDetails),
                'midtrans_config' => [
                    'server_key_set' => !empty(config('midtrans.server_key')),
                    'client_key_set' => !empty(config('midtrans.client_key')),
                    'is_production' => config('midtrans.is_production'),
                    'is_sanitized' => config('midtrans.is_sanitized'),
                    'is_3ds' => config('midtrans.is_3ds'),
                ]
            ]);

            try {
                $snapToken = \Midtrans\Snap::getSnapToken($params);
                Log::info('Jeep Trip Final Booking: Midtrans snap token generated successfully', [
                    'order_id' => $orderId,
                    'snap_token_length' => strlen($snapToken),
                    'snap_token_preview' => substr($snapToken, 0, 20) . '...'
                ]);
            } catch (\Exception $e) {
                Log::error('Jeep Trip Final Booking: Midtrans snap token generation failed', [
                    'order_id' => $orderId,
                    'error_message' => $e->getMessage(),
                    'error_code' => $e->getCode(),
                    'midtrans_config' => [
                        'server_key_length' => strlen(config('midtrans.server_key')),
                        'client_key_length' => strlen(config('midtrans.client_key')),
                        'is_production' => config('midtrans.is_production'),
                    ]
                ]);
                DB::rollBack();
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal menghubungi payment gateway. Silakan coba lagi.'
                ], 500);
            }

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
     * Get DP percentage from settings
     */
    private function getDpPercentage()
    {
        $dpSetting = Setting::where('key', 'dp')->first();
        return $dpSetting ? (float) $dpSetting->value : 50.0; // Default 50% if not set
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
     * Get availability data for a specific slot and date
     */
    public function getAvailability(Request $request)
    {
        $request->validate([
            'slot_id' => 'required|string|exists:jeep_trip_slots,id',
            'tanggal' => 'required|date|after_or_equal:today'
        ]);

        $slot = JeepTripSlot::findOrFail($request->slot_id);
        $availability = $slot->getAvailabilityForDate($request->tanggal);

        if (!$availability) {
            return response()->json([
                'available' => false,
                'quota_jeep' => 0,
                'quota_terpakai' => 0,
                'quota_tersedia' => 0,
                'is_closed' => false,
                'message' => 'Tidak ada availability untuk tanggal ini'
            ]);
        }

        return response()->json([
            'available' => true,
            'quota_jeep' => $availability->quota_jeep,
            'quota_terpakai' => $availability->quota_terpakai,
            'quota_tersedia' => $availability->getQuotaTersedia(),
            'is_closed' => $availability->is_closed,
            'message' => $availability->is_closed ? 'Slot ditutup' : 'Slot tersedia'
        ]);
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