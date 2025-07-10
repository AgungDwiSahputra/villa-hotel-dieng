<?php

namespace App\Http\Controllers\Admin\Produk;

use App\DataTables\Admin\Produk\ProdukImageDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Produk\ProdukImageRequest;
use App\Models\Produk\Produk;
use App\Models\Produk\ProdukImage;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class ProdukImageController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:Produk Image (Index)', only: ['index']),
            new Middleware('permission:Produk Image (Delete)', only: ['destroy']),
        ];
    }

    public function index(ProdukImageDataTable $dataTable, Request $request)
    {
        $produk = Produk::findOrFail($request->produk);
        return $dataTable->render('admin.produk.image.index',[
            'produk' => $produk,
        ]);
    }

    public function store(ProdukImageRequest $request)
    {
        $datas = Arr::except($request->validated(), ['image']);
        if($request->image){
            $datas['image'] = storeImage($request, 'image', 'Produk\ProdukImage');
        }
        ProdukImage::updateOrCreate([
            'id' => $request->id
        ], $datas);

        return response()->json(['status' => true]);
    }

    public function edit(string $id)
    {
        $data = ProdukImage::find($id);
        return response()->json([
            'data' => $data,
        ]);
    }

    public function destroy(string $id)
    {
        $data = ProdukImage::findOrFail($id);
        $data->delete();
        Storage::disk('public')->delete($data->image);
    return response()->json(['status' => true]);
    }
}
