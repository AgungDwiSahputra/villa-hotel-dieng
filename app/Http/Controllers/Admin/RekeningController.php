<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\RekeningDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\RekeningRequest;
use App\Models\Rekening;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class RekeningController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:Rekening (Index)', only: ['index']),
            new Middleware('permission:Rekening (Delete)', only: ['destroy']),
        ];
    }

    public function index(RekeningDataTable $dataTable, Request $request)
    {
        return $dataTable->render('admin.rekening.index');
    }

    public function store(RekeningRequest $request)
    {
        $datas = Arr::except($request->validated(), ['image']);
        if($request->image){
            $datas['image'] = storeImage($request, 'image', 'Rekening');
        }
        
        Rekening::updateOrCreate([
            'id' => $request->id
        ], $datas);

        return response()->json(['status' => true]);
    }

    public function edit(string $id)
    {
        $data = Rekening::find($id);
        return response()->json([
            'data' => $data,
        ]);
    }

    public function destroy(string $id)
    {
        $data = Rekening::findOrFail($id);
        $data->delete();
        Storage::disk('public')->delete($data->image);
        return response()->json(['status' => true]);
    }
}