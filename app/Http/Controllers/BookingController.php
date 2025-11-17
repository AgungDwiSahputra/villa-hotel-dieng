<?php

namespace App\Http\Controllers;

use App\Http\Requests\Landing\ProdukFinalRequest;
use App\Mail\PaymentSuccess;
use App\Models\Promo\Promo;
use App\Models\Produk\Produk;
use App\Models\Transaksi\Transaksi;
use App\Models\Transaksi\TransaksiDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Midtrans\Config;

class BookingController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function processBooking(ProdukFinalRequest $request)
    {
        $datas = $request->validated();

        // Log received data for debugging
        Log::info('Booking Process - Received Data:', [
            'produk_id' => $datas['produk_id'],
            'promo_code' => $datas['promo_code'] ?? null,
            'total' => $datas['total'],
            'dp' => $datas['dp'],
            'unit' => $datas['unit'],
            'night' => $datas['night'],
        ]);

        try {
            DB::beginTransaction();

            $produk = Produk::findOrFail($datas['produk_id']);
            $promo = null;
            $discountAmount = 0;
            $originalTotal = $datas['total'];
            $finalTotal = $datas['total'];
            $finalDp = $datas['dp'];

            // Validate and apply promo code if provided
            if (!empty($datas['promo_code'])) {
                $promo = Promo::where('promo_code', $datas['promo_code'])
                    ->where('is_active', true)
                    ->first();

                if (!$promo) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Kode promo tidak valid atau tidak aktif.'
                    ], 422);
                }

                // Validate promo
                if (!$promo->isValid()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Kode promo sudah tidak berlaku atau sudah mencapai batas penggunaan.'
                    ], 422);
                }

                // Check if promo is applicable to this product
                if (!$promo->isApplicableToProduct($produk)) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Kode promo tidak berlaku untuk produk ini.'
                    ], 422);
                }

                // Calculate original price (before discount) based on actual date range
                $calculatedOriginalTotal = $produk->calculateTotalPriceForRange(
                    $datas['start_date'],
                    $datas['end_date'],
                    $datas['unit']
                );

                // Calculate discount based on original price
                $discountConfig = $promo->getEffectiveDiscountForProduct($produk);

                if ($discountConfig['type'] === 'percentage') {
                    $discountAmount = $calculatedOriginalTotal * ($discountConfig['value'] / 100);
                } else {
                    $discountAmount = min($discountConfig['value'], $calculatedOriginalTotal);
                }

                Log::info("Discount Amount:", ["amount" => $discountAmount, "promo_type" => $discountConfig["type"], "promo_value" => $discountConfig["value"]], "booking_process");

                // The final total and DP should match what was calculated in frontend
                $expectedFinalTotal = max(0, $calculatedOriginalTotal - $discountAmount);
                $expectedDpPercentage = $datas['dp'] / $datas['total']; // DP percentage from frontend
                $expectedFinalDp = $expectedFinalTotal * $expectedDpPercentage;

                // Use the values from frontend if they match our calculation (within tolerance)
                // This prevents double-discounting when promo was applied in frontend
                if (abs($datas['total'] - $expectedFinalTotal) < 0.01 &&
                    abs($datas['dp'] - $expectedFinalDp) < 0.01) {
                    // Frontend calculation matches backend - use frontend values
                    $finalTotal = $datas['total'];
                    $finalDp = $datas['dp'];
                } else {
                    // Fallback to backend calculation if there's a mismatch
                    $finalTotal = $expectedFinalTotal;
                    $finalDp = $expectedFinalDp;
                }

                // Store the calculated original total for database
                $originalTotal = $calculatedOriginalTotal;
            }

            $orderId = uniqid();

            $transaksi = Transaksi::create([
                'produk_id' => $datas['produk_id'],
                'order_id' => $orderId,
                'start_date' => $datas['start_date'],
                'end_date' => $datas['end_date'],
                'night' => $datas['night'],
                'unit' => $datas['unit'],
                'total' => $finalDp,
                'original_total' => $originalTotal,
                'discount_amount' => $discountAmount,
                'promo_id' => $promo ? $promo->id : null,
                'promo_code' => $promo ? $promo->promo_code : null,
                'name' => $datas['name'],
                'email' => $datas['email'],
                'no_wa' => $datas['no_wa'],
            ]);

            $start = Carbon::parse($transaksi->start_date);
            $end = Carbon::parse($transaksi->end_date);

            for ($date = $start; $date->lt($end); $date->addDay()) {
                TransaksiDetail::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id' => $datas['produk_id'],
                    'date' => $date->format('Y-m-d'),
                    'unit' => $datas['unit'],
                ]);
            }

            $transaction = Transaksi::with('produk')->find($transaksi->id);

            $itemDetails = [
                [
                    'id' => $datas['produk_id'],
                    'price' => (int) $finalDp,
                    'quantity' => 1,
                    'name' => $transaction->produk->name . ', ' . $datas['night'] . ' malam, ' . $datas['unit'] . ' unit',
                ],
            ];

            // Add discount as item if promo applied
            // if ($promo && $discountAmount > 0) {
            //     $itemDetails[] = [
            //         'id' => 'DISCOUNT-' . $promo->promo_code,
            //         'price' => (int) -$discountAmount,
            //         'quantity' => 1,
            //         'name' => 'Diskon Promo: ' . $promo->name,
            //     ];
            // }

            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => (int) $finalDp,
                ],
                'customer_details' => [
                    'first_name' => $datas['name'],
                    'email' => $datas['email'],
                    'phone' => $datas['no_wa'],
                ],
                'item_details' => $itemDetails,
                'enabled_payments' => ['gopay', 'bank_transfer'],
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // Increment promo usage count if promo was applied
            if ($promo) {
                $promo->incrementUsage();
            }

            Log::info('Snap Params:', $params);
            Log::info('Order ID:', ['order_id' => $orderId]);
            if ($promo) {
                Log::info('Promo Applied:', [
                    'promo_id' => $promo->id,
                    'promo_code' => $promo->promo_code,
                    'discount_amount' => $discountAmount
                ]);
            }

            DB::commit();

            // Clear booking session after successful booking
            session()->forget('produk_booking');

            return response()->json([
                'status' => 'success',
                'snap_token' => $snapToken,
                'order_id' => $orderId,
                'message' => 'Booking berhasil dibuat, silakan lakukan pembayaran'
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            Log::error('Booking Error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memproses booking: ' . $e->getMessage()
            ], 500);
        }
    }

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
            Log::warning('Midtrans notification signature mismatch.', ['order_id' => $orderId]);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $transaction = Transaksi::where('order_id', $orderId)->first();

        if (!$transaction) {
            Log::error('Transaction not found for order_id:', ['order_id' => $orderId]);
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'accept') {
                $transaction->status = 'success';
            }
        } else if ($transactionStatus == 'settlement') {
            $transaction->status = 'success';
        } else if ($transactionStatus == 'pending') {
            $transaction->status = 'pending';
        } else if ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
            $transaction->status = 'failed';
        }

        $transaction->save();

        // Send email notification if payment was successful
        if ($transaction->status === 'success') {
            try {
                // Load produk relationship for email template
                $transaction->load('produk');
                Mail::to($transaction->email)->send(new PaymentSuccess($transaction));
                Log::info('Payment success email sent.', ['order_id' => $orderId, 'email' => $transaction->email]);
            } catch (\Exception $e) {
                Log::error('Failed to send payment success email.', [
                    'order_id' => $orderId,
                    'email' => $transaction->email,
                    'error' => $e->getMessage()
                ]);
            }
        }

        Log::info('Midtrans notification processed successfully.', ['order_id' => $orderId, 'status' => $transaction->status]);

        return response()->json(['message' => 'Notification processed successfully'], 200);
    }
}

