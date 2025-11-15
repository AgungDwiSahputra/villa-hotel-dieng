<?php

namespace App\Http\Controllers;

use App\Http\Requests\Landing\ProdukFinalRequest;
use App\Models\Promo\Promo;
use App\Models\Produk\Produk;
use App\Models\Transaksi\Transaksi;
use App\Models\Transaksi\TransaksiDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

                // Calculate discount
                $discountConfig = $promo->getEffectiveDiscountForProduct($produk);
                
                // Calculate price per night (simplified - using average of weekday/weekend)
                $avgPricePerNight = ($produk->harga_weekday + $produk->harga_weekend) / 2;
                $totalPrice = $avgPricePerNight * $datas['night'] * $datas['unit'];

                if ($discountConfig['type'] === 'percentage') {
                    $discountAmount = $totalPrice * ($discountConfig['value'] / 100);
                } else {
                    $discountAmount = min($discountConfig['value'], $totalPrice);
                }

                $finalTotal = max(0, $totalPrice - $discountAmount);
                
                // Recalculate DP based on discount
                $dpPercentage = $datas['dp'] / $originalTotal;
                $finalDp = $finalTotal * $dpPercentage;
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
                    'produk_id' => session('produk_booking')['produk_id'],
                    'date' => $date->format('Y-m-d'),
                    'unit' => session('produk_booking')['unit'],
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
            if ($promo && $discountAmount > 0) {
                $itemDetails[] = [
                    'id' => 'DISCOUNT-' . $promo->promo_code,
                    'price' => (int) -$discountAmount,
                    'quantity' => 1,
                    'name' => 'Diskon Promo: ' . $promo->name,
                ];
            }

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

        Log::info('Midtrans notification processed successfully.', ['order_id' => $orderId, 'status' => $transaction->status]);

        return response()->json(['message' => 'Notification processed successfully'], 200);
    }
}
