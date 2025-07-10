<?php

namespace App\Http\Controllers\Admin\Produk;

use App\DataTables\Admin\Produk\ProdukSyaratDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Produk\ProdukSyaratRequest;
use App\Models\Produk\Produk;
use App\Models\Produk\ProdukSyarat;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ProdukSyaratController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:Produk Syarat (Index)', only: ['index']),
            new Middleware('permission:Produk Syarat (Delete)', only: ['destroy']),
        ];
    }

    public function index(ProdukSyaratDataTable $dataTable, Request $request)
    {
        $produk = Produk::findOrFail($request->produk);
        return $dataTable->render('admin.produk.syarat.index',[
            'produk' => $produk
        ]);
    }

    public function store(ProdukSyaratRequest $request)
    {
        ProdukSyarat::updateOrCreate([
            'id' => $request->id
        ],$request->validated());

        return response()->json(['status' => true]);
    }

    public function edit(string $id)
    {
        $data = ProdukSyarat::find($id);
        return response()->json([
            'data' => $data,
        ]);
    }

    public function destroy(string $id)
    {
        ProdukSyarat::findOrFail($id)->delete();
        return response()->json();
    }
}
