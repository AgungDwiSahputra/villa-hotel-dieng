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

    public function storeProduct(Request $request)
    {
        try {
            $product = Produk::create($request->all());
            return response()->json(['status' => true, 'message' => 'Product created successfully', 'data' => $product]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => false, 'message' => 'Validation failed', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        }
    }

    public function updateProductById(Request $request, $id)
    {
        $product = Produk::find($id);
        if ($product === null) {
            return response()->json(['status' => false, 'message' => 'Product not found'], 404);
        }

        try {
            $product->update($request->all());
            return response()->json(['status' => true, 'message' => 'Product updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        }
    }

    public function deleteProductById($id)
    {
        $product = Produk::find($id);
        if ($product === null) {
            return response()->json(['status' => false, 'message' => 'Product not found'], 404);
        }

        try {
            $product->delete();
            return response()->json(['status' => true, 'message' => 'Product deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        }
    }

    public function deleteProductByOwner($owner)
    {
        $product = Produk::where('owner', $owner);
        if ($product === null) {
            return response()->json(['status' => false, 'message' => 'Product not found'], 404);
        }

        try {
            $product->delete();
            return response()->json(['status' => true, 'message' => 'Product deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        }
    }
}

