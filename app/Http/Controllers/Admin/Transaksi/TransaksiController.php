<?php

namespace App\Http\Controllers\Admin\Transaksi;

use App\DataTables\Admin\Transaksi\TransaksiDataTable;
use App\Http\Controllers\Controller;
use App\Models\Transaksi\Transaksi;
use App\Models\Transaksi\TransaksiDetail;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class TransaksiController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:Transaksi (Index)', only: ['index']),
            new Middleware('permission:Transaksi (Delete)', only: ['destroy']),
        ];
    }

    public function index(TransaksiDataTable $dataTable, Request $request)
    {
        return $dataTable->render('admin.transaksi.transaksi.index');
    }
    public function store(Request $request){
        $transaksi = Transaksi::find($request->id);
        $transaksi->status = $request->status;
        $transaksi->save();

        $transaksiDetail = TransaksiDetail::where('transaksi_id', $transaksi->id)->update([
            'status' => $request->status,
        ]);
        return response()->json(['status' => true]);
    }
}