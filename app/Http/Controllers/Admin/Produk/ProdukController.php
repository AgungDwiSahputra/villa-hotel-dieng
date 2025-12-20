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
use Illuminate\Support\Facades\Log;
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
        Log::info('ProdukController index called', [
            'is_ajax' => request()->ajax(),
            'datatable_param' => request()->get('draw'),
            'user_agent' => request()->userAgent(),
            'url' => request()->fullUrl()
        ]);

        try {
            $response = $dataTable->render('admin.produk.produk.index',[
                'categories' => ProdukCategory::orderBy('name')->get(),
            ]);

            if (request()->ajax()) {
                Log::info('ProdukController returning AJAX response', [
                    'response_type' => gettype($response),
                    'response_content' => is_string($response) ? substr($response, 0, 500) : json_encode($response)
                ]);
            }

            return $response;
        } catch (\Exception $e) {
            Log::error('ProdukController index failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'is_ajax' => request()->ajax()
            ]);
            throw $e;
        }
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
