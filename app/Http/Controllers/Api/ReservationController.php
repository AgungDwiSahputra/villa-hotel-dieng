<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaksi\Transaksi;
use App\Models\Transaksi\TransaksiDetail;

class ReservationController extends Controller
{
    public function index()
    {
        // Query ini mengambil daftar transaksi beserta nama produk dan kategori terkait.
        // Ia juga menghitung 'detail_status' untuk setiap transaksi dengan memeriksa rincian transaksi terkait.
        // Jika ada rincian yang memiliki status 'MENUNGGU', maka 'detail_status' adalah 'MENUNGGU'; jika tidak, maka 'detail_status' adalah nilai status maksimum.
        // Jika tidak ada rincian yang ada, maka 'detail_status' default ke 'BERHASIL'.
        return Transaksi::select([
            'transaksis.id',
            'transaksis.name',
            'transaksis.order_id',
            'produks.owner as produk_owner',
            'produks.name as produk_name',
            'produk_categories.name as category_name',
            'transaksis.start_date',
            'transaksis.end_date',
            'transaksis.total',
            'transaksis.unit',
            'transaksis.no_wa',
            'transaksis.status',
            'transaksis.created_at'
        ])
        ->selectRaw("
            COALESCE(
                (
                    SELECT 
                        CASE 
                            WHEN SUM(CASE WHEN transaksi_details.status = 'PENDING' THEN 1 ELSE 0 END) > 0 THEN 'PENDING'
                            ELSE MAX(transaksi_details.status)
                        END
                    FROM transaksi_details 
                    WHERE transaksi_details.transaksi_id = transaksis.id
                ),
                'SUCCESS'
            ) as detail_status
        ")
        ->join('produks', 'transaksis.produk_id', '=', 'produks.id')
        ->join('produk_categories', 'produks.category_id', '=', 'produk_categories.id')
        ->orderBy('transaksis.created_at','desc')
        ->get();
    }

    public function indexDetail($transaksiId)
    {
        return TransaksiDetail::select([
            'transaksis.name',
            'transaksi_details.id',
            'transaksi_details.transaksi_id',
            'transaksi_details.date',
            'transaksi_details.unit',
            'transaksi_details.status',
            'transaksi_details.created_at',
            'produks.owner as produk_owner',
            'produks.name as produk_name',
            'produk_categories.name as category_name'
        ])
        ->join('transaksis', 'transaksi_details.transaksi_id', '=', 'transaksis.id')
        ->join('produks', 'transaksi_details.produk_id', '=', 'produks.id')
        ->join('produk_categories', 'produks.category_id', '=', 'produk_categories.id')
        ->where('transaksi_details.transaksi_id', $transaksiId)
        ->get();
    }

    public function reservationByDate($date, $produkId = null)
    {
        return TransaksiDetail::select([
            'transaksis.name',
            'transaksi_details.id',
            'transaksi_details.transaksi_id',
            'transaksi_details.date',
            'transaksi_details.unit',
            'transaksi_details.status',
            'transaksi_details.created_at',
            'produks.owner as produk_owner',
            'produks.name as produk_name',
            'produk_categories.name as category_name'
        ])
        ->join('transaksis', 'transaksi_details.transaksi_id', '=', 'transaksis.id')
        ->join('produks', 'transaksi_details.produk_id', '=', 'produks.id')
        ->join('produk_categories', 'produks.category_id', '=', 'produk_categories.id')
        ->whereDate('transaksi_details.date', $date)
        ->when($produkId, function ($query) use ($produkId) {
            return $query->where('transaksi_details.produk_id', $produkId);
        })
        ->get();
    }

    public function acceptAllByTransaksi($id, $date = null)
    {
        $reservations = TransaksiDetail::where('transaksi_id', $id)
            ->when($date, function ($query) use ($date) {
                return $query->whereDate('date', $date);
            })
            ->get();

        if ($reservations->isEmpty()) {
            return response()->json(['message' => 'No reservations found'], 404);
        }

        foreach ($reservations as $reservation) {
            try {
                $reservation->status = 'APPROVED';
                $reservation->save();
            } catch (\Exception $e) {
                return response()->json(['message' => 'Error processing reservation: ' . $e->getMessage()], 500);
            }
        }

        // Kirim email notifikasi jika perlu
        return response()->json(['message' => 'Reservation approved']);
    }

    public function rejectAllByTransaksi($id, $date = null)
    {
        $reservations = TransaksiDetail::where('transaksi_id', $id)
            ->when($date, function ($query) use ($date) {
                return $query->whereDate('date', $date);
            })
            ->get();

        if ($reservations->isEmpty()) {
            return response()->json(['message' => 'No reservations found'], 404);
        }

        foreach ($reservations as $reservation) {
            try {
                $reservation->status = 'REJECTED';
                $reservation->save();
            } catch (\Exception $e) {
                return response()->json(['message' => 'Error processing reservation: ' . $e->getMessage()], 500);
            }
        }

        // Kirim email notifikasi jika perlu
        return response()->json(['message' => 'Reservation rejected']);
    }

    public function acceptAll($id, $date = null)
    {
        $reservations = TransaksiDetail::where('produk_id', $id)
            ->when($date, function ($query) use ($date) {
                return $query->whereDate('date', $date);
            })
            ->get();

        if ($reservations->isEmpty()) {
            return response()->json(['message' => 'No reservations found'], 404);
        }

        foreach ($reservations as $reservation) {
            try {
                $reservation->status = 'APPROVED';
                $reservation->save();
            } catch (\Exception $e) {
                return response()->json(['message' => 'Error processing reservation: ' . $e->getMessage()], 500);
            }
        }

        // Kirim email notifikasi jika perlu
        return response()->json(['message' => 'Reservation approved']);
    }

    public function rejectAll($id, $date = null)
    {
        $reservations = TransaksiDetail::where('produk_id', $id)
            ->when($date, function ($query) use ($date) {
                return $query->whereDate('date', $date);
            })
            ->get();

            return $reservations;

        if ($reservations->isEmpty()) {
            return response()->json(['message' => 'No reservations found'], 404);
        }

        foreach ($reservations as $reservation) {
            try {
                $reservation->status = 'REJECTED';
                $reservation->save();
            } catch (\Exception $e) {
                return response()->json(['message' => 'Error processing reservation: ' . $e->getMessage()], 500);
            }
        }

        // Kirim email notifikasi jika perlu
        return response()->json(['message' => 'Reservation rejected']);
    }

    public function accept($id)
    {
        $reservation = TransaksiDetail::where('id', $id)->first();
        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }
        $reservation->status = 'APPROVED';
        $reservation->save();

        // Kirim email notifikasi jika perlu
        return response()->json(['message' => 'Reservation approved']);
    }

    public function reject($id)
    {
        $reservation = TransaksiDetail::where('id', $id)->first();
        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }
        $reservation->status = 'REJECTED';
        $reservation->save();

        // Kirim email notifikasi jika perlu
        return response()->json(['message' => 'Reservation rejected']);
    }
}

