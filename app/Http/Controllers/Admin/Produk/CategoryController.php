<?php

namespace App\Http\Controllers\Admin\Produk;

use App\DataTables\Admin\Produk\ProdukCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Produk\ProdukCategoryRequest;
use App\Models\Produk\ProdukCategory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Str;

class CategoryController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:Produk Category (Index)', only: ['index']),
            new Middleware('permission:Produk Category (Delete)', only: ['destroy']),
        ];
    }

    public function index(ProdukCategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.produk.category.index');
    }

    public function store(ProdukCategoryRequest $request)
    {
        $datas = $request->validated();
        $datas['slug'] = Str::slug($request->name);
        ProdukCategory::updateOrCreate([
            'id' => $request->id
        ],$datas);

        return response()->json(['status' => true]);
    }

    public function edit(string $id)
    {
        $data = ProdukCategory::find($id);
        return response()->json([
            'data' => $data,
        ]);
    }

    public function destroy(string $id)
    {
        ProdukCategory::findOrFail($id)->delete();
        return response()->json();
    }
}
