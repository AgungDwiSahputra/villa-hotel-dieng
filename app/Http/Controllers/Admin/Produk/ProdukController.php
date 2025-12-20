<?php

namespace App\Http\Controllers\Admin\Produk;

use App\DataTables\Admin\Produk\ProdukDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Produk\ProdukRequest;
use App\Models\Produk\Produk;
use App\Models\Produk\ProdukCategory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Str;

class ProdukController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:Produk (Index)', only: ['index']),
            new Middleware('permission:Produk (Delete)', only: ['destroy']),
        ];
    }

    public function index(ProdukDataTable $dataTable)
    {
        return $dataTable->render('admin.produk.produk.index',[
            'categories' => ProdukCategory::orderBy('name')->get(),
        ]);
    }

    public function store(ProdukRequest $request)
    {
        $datas = $request->validated();
        $datas['slug'] = Str::slug($request->name);
        Produk::updateOrCreate([
            'id' => $request->id
        ],$datas);

        return response()->json(['status' => true]);
    }

    public function edit(string $id)
    {
        $data = Produk::find($id);
        return response()->json([
            'data' => $data,
        ]);
    }

    public function destroy(string $id)
    {
        Produk::findOrFail($id)->delete();
        return response()->json();
    }
}
