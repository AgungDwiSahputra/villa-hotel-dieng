<?php

namespace App\Http\Controllers\Admin\Produk;

use App\DataTables\Admin\Produk\ProdukFasilitasDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Produk\ProdukFasilitasRequest;
use App\Models\Produk\Produk;
use App\Models\Produk\ProdukFasilitas;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ProdukFasilitasController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:Produk Fasilitas (Index)', only: ['index']),
            new Middleware('permission:Produk Fasilitas (Delete)', only: ['destroy']),
        ];
    }

    public function index(ProdukFasilitasDataTable $dataTable, Request $request)
    {
        $produk = Produk::findOrFail($request->produk);
        return $dataTable->render('admin.produk.fasilitas.index',[
            'produk' => $produk,
        ]);
    }

    public function store(ProdukFasilitasRequest $request)
    {
        ProdukFasilitas::updateOrCreate([
            'id' => $request->id
        ],$request->validated());

        return response()->json(['status' => true]);
    }

    public function edit(string $id)
    {
        $data = ProdukFasilitas::find($id);
        return response()->json([
            'data' => $data,
        ]);
    }

    public function destroy(string $id)
    {
        ProdukFasilitas::findOrFail($id)->delete();
        return response()->json();
    }
}
