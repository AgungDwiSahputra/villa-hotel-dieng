<?php

namespace App\Http\Controllers\Admin\Produk;

use App\DataTables\Admin\Produk\ProdukWisataDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Produk\ProdukWisataRequest;
use App\Models\Produk\Produk;
use App\Models\Produk\ProdukWisata;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ProdukWisataController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:Produk Wisata (Index)', only: ['index']),
            new Middleware('permission:Produk Wisata (Delete)', only: ['destroy']),
        ];
    }

    public function index(ProdukWisataDataTable $dataTable, Request $request)
    {
        $produk = Produk::findOrFail($request->produk);
        return $dataTable->render('admin.produk.wisata.index',[
            'produk' => $produk
        ]);
    }

    public function store(ProdukWisataRequest $request)
    {
        ProdukWisata::updateOrCreate([
            'id' => $request->id
        ],$request->validated());

        return response()->json(['status' => true]);
    }

    public function edit(string $id)
    {
        $data = ProdukWisata::find($id);
        return response()->json([
            'data' => $data,
        ]);
    }

    public function destroy(string $id)
    {
        ProdukWisata::findOrFail($id)->delete();
        return response()->json();
    }
}
