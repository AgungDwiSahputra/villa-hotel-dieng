<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produk\Produk;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getAllProduct()
    {
        return Produk::orderBy("created_at","desc")->get();
    }

    public function getProductById($id)
    {
        return Produk::where("id", $id)->orderBy("created_at","desc")->first();
    }

    public function updateProductById(Request $request, $id)
    {
        $product = Produk::find($id);
        if ($product) {
            $product->update($request->all());
            return response()->json(['status' => true, 'message' => 'Product updated successfully']);
        }
        return response()->json(['status' => false, 'message' => 'Product not found'], 404);
    }
}

