<?php

namespace App\Http\Controllers;

use App\Http\Requests\Landing\ProdukFinalRequest;
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

        // dd($datas);

        try {
            DB::beginTransaction();

            $orderId =  uniqid();

            $transaksi = Transaksi::create([
                'produk_id' => $datas['produk_id'],
                'order_id' => $orderId,
                'start_date' => $datas['start_date'],
                'end_date' => $datas['end_date'],
                'night' => $datas['night'],
                'unit' => $datas['unit'],
                'total' => $datas['dp'],
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

            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => $datas['dp'],
                ],
                'customer_details' => [
                    'first_name' => $datas['name'],
                    'email' => $datas['email'],
                    'phone' => $datas['no_wa'],
                ],
                'item_details' => [
                    [
                        'id' => $datas['produk_id'],
                        'price' => $datas['dp'],
                        'quantity' => 1,
                        'name' => $transaction->produk->name . ', ' . $datas['night'] . ' malam, ' . $datas['unit'] . ' unit',
                    ],
                ],
                'enabled_payments' => ['gopay', 'bank_transfer'],
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($params);

            Log::info('Snap Params:', $params);
            Log::info('Order ID:', ['order_id' => $orderId]);

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
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);

        $notification = new \Midtrans\Notification();

        $orderId = $notification->order_id ?? null;
        $transactionStatus = $notification->transaction_status ?? null;
        $fraudStatus = $notification->fraud_status ?? null;
        $signatureKey = $notification->signature_key ?? null;

        if (!$orderId) {
            Log::warning('Midtrans notification missing order_id.', ['notification' => $notification]);
            return response()->json(['message' => 'Missing order_id'], 400);
        }

        $localSignatureKey = hash('sha512', $orderId . $transactionStatus . $notification->gross_amount . config('midtrans.server_key'));

        if ($signatureKey !== $localSignatureKey) {
            Log::warning('Midtrans notification signature mismatch.', ['order_id' => $orderId]);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $transaction = Transaksi::where('order_id', $orderId)->first();

        if (!$transaction) {
            Log::error('Transaction not found for order_id:', ['order_id' => $orderId]);
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        try {
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
        } catch (\Exception $e) {
            Log::error('Error updating transaction status:', ['order_id' => $orderId, 'error' => $e->getMessage()]);
            return response()->json(['message' => 'Error updating transaction status'], 500);
        }
    }
}
