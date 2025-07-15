<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produk\Produk;

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
}

