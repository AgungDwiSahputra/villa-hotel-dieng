<?php

namespace App\Http\Controllers\Admin\JeepTrip;

use App\DataTables\Admin\JeepTrip\JeepTripImageDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\JeepTrip\JeepTripImageRequest;
use App\Models\JeepTrip\JeepTrip;
use App\Models\JeepTrip\JeepTripImage;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class JeepTripImageController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:Jeep Trip Image (Index)', only: ['index']),
            new Middleware('permission:Jeep Trip Image (Create)', only: ['store']),
            new Middleware('permission:Jeep Trip Image (Edit)', only: ['edit', 'update']),
            new Middleware('permission:Jeep Trip Image (Delete)', only: ['destroy']),
        ];
    }

    public function index(JeepTripImageDataTable $dataTable, Request $request)
    {
        $jeepTrip = JeepTrip::findOrFail($request->jeep_trip);
        return $dataTable->render('admin.jeep-trip.image.index', [
            'jeepTrip' => $jeepTrip,
        ]);
    }

    public function store(JeepTripImageRequest $request)
    {
        $datas = Arr::except($request->validated(), ['image']);
        if ($request->hasFile('image')) {
            $datas['image_path'] = storeImage($request, 'image', 'JeepTrip\JeepTripImage');
        }
        JeepTripImage::updateOrCreate([
            'id' => $request->id
        ], $datas);

        return response()->json(['status' => true]);
    }

    public function edit(string $id)
    {
        $data = JeepTripImage::find($id);
        return response()->json([
            'data' => $data,
        ]);
    }

    public function destroy(string $id)
    {
        $data = JeepTripImage::findOrFail($id);
        $data->delete();
        Storage::disk('public')->delete($data->image_path);

        return response()->json(['status' => true]);
    }
}
