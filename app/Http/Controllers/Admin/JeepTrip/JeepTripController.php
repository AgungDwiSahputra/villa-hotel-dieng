<?php

namespace App\Http\Controllers\Admin\JeepTrip;

use App\DataTables\Admin\JeepTrip\JeepTripDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\JeepTrip\JeepTripRequest;
use App\Models\JeepTrip\JeepTrip;
use App\Models\JeepTrip\JeepTripDestination;
use App\Models\JeepTrip\JeepTripExclude;
use App\Models\JeepTrip\JeepTripImage;
use App\Models\JeepTrip\JeepTripInclude;
use App\Models\JeepTrip\JeepTripSlot;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class JeepTripController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:Jeep Trip (Index)', only: ['index']),
            new Middleware('permission:Jeep Trip (Create)', only: ['store']),
            new Middleware('permission:Jeep Trip (Edit)', only: ['edit', 'update']),
            new Middleware('permission:Jeep Trip (Delete)', only: ['destroy']),
        ];
    }

    public function index(JeepTripDataTable $dataTable)
    {
        return $dataTable->render('admin.jeep-trip.jeep-trip.index');
    }

    public function create()
    {
        return view('admin.jeep-trip.jeep-trip.create');
    }

    public function store(JeepTripRequest $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validated();

            // Create slug
            $validated['slug'] = Str::slug($request->nama_paket);

            // Check if slug already exists
            if (JeepTrip::where('slug', $validated['slug'])->exists()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Nama Paket sudah digunakan. Silakan gunakan nama paket yang berbeda.'
                ], 422);
            }

            // Create JeepTrip
            $jeepTrip = JeepTrip::create($validated);

            // Handle destinations
            if ($request->has('destinations') && is_array($request->destinations)) {
                foreach ($request->destinations as $index => $destination) {
                    if (!empty($destination['nama_destinasi'])) {
                        JeepTripDestination::create([
                            'jeep_trip_id' => $jeepTrip->id,
                            'nama_destinasi' => $destination['nama_destinasi'],
                            'urutan' => $index + 1,
                        ]);
                    }
                }
            }

            // Handle includes
            if ($request->has('includes') && is_array($request->includes)) {
                foreach ($request->includes as $include) {
                    if (!empty($include['nama_item'])) {
                        JeepTripInclude::create([
                            'jeep_trip_id' => $jeepTrip->id,
                            'nama_item' => $include['nama_item'],
                        ]);
                    }
                }
            }

            // Handle excludes
            if ($request->has('excludes') && is_array($request->excludes)) {
                foreach ($request->excludes as $exclude) {
                    if (!empty($exclude['nama_item'])) {
                        JeepTripExclude::create([
                            'jeep_trip_id' => $jeepTrip->id,
                            'nama_item' => $exclude['nama_item'],
                        ]);
                    }
                }
            }

            // Handle images
            if ($request->hasFile('images')) {
                $this->handleImageUploads($jeepTrip, $request->file('images'));
            }

            // Handle slots
            if ($request->has('slots') && is_array($request->slots)) {
                foreach ($request->slots as $slotData) {
                    if (!empty($slotData['nama_slot'])) {
                        JeepTripSlot::create([
                            'jeep_trip_id' => $jeepTrip->id,
                            'nama_slot' => $slotData['nama_slot'],
                            'jam_mulai' => $slotData['jam_mulai'],
                            'jam_selesai' => $slotData['jam_selesai'],
                            'is_active' => $slotData['is_active'] ?? true,
                        ]);
                    }
                }
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Paket Jeep Trip berhasil dibuat'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating JeepTrip: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat membuat paket Jeep Trip'. $e->getMessage()
            ], 500);
        }
    }

    public function show(string $id)
    {
        $jeepTrip = JeepTrip::with([
            'destinations', 'includes', 'excludes', 'images', 'slots.availabilities'
        ])->findOrFail($id);

        return view('admin.jeep-trip.jeep-trip.show', compact('jeepTrip'));
    }

    public function edit(string $id)
    {
        $jeepTrip = JeepTrip::with([
            'destinations', 'includes', 'excludes', 'images', 'slots.availabilities'
        ])->findOrFail($id);

        return response()->json([
            'data' => $jeepTrip,
        ]);
    }

    public function update(JeepTripRequest $request, string $id)
    {
        try {
            DB::beginTransaction();

            $jeepTrip = JeepTrip::findOrFail($id);
            $validated = $request->validated();

            // Update slug if name changed
            if ($request->nama_paket !== $jeepTrip->nama_paket) {
                $validated['slug'] = Str::slug($request->nama_paket);

                // Check if new slug already exists (excluding current record)
                if (JeepTrip::where('slug', $validated['slug'])->where('id', '!=', $id)->exists()) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Nama Paket sudah digunakan. Silakan gunakan nama paket yang berbeda.'
                    ], 422);
                }
            }

            // Update JeepTrip
            $jeepTrip->update($validated);

            // Handle destinations
            $jeepTrip->destinations()->delete(); // Delete existing
            if ($request->has('destinations') && is_array($request->destinations)) {
                foreach ($request->destinations as $index => $destination) {
                    if (!empty($destination['nama_destinasi'])) {
                        JeepTripDestination::create([
                            'jeep_trip_id' => $jeepTrip->id,
                            'nama_destinasi' => $destination['nama_destinasi'],
                            'urutan' => $index + 1,
                        ]);
                    }
                }
            }

            // Handle includes
            $jeepTrip->includes()->delete(); // Delete existing
            if ($request->has('includes') && is_array($request->includes)) {
                foreach ($request->includes as $include) {
                    if (!empty($include['nama_item'])) {
                        JeepTripInclude::create([
                            'jeep_trip_id' => $jeepTrip->id,
                            'nama_item' => $include['nama_item'],
                        ]);
                    }
                }
            }

            // Handle excludes
            $jeepTrip->excludes()->delete(); // Delete existing
            if ($request->has('excludes') && is_array($request->excludes)) {
                foreach ($request->excludes as $exclude) {
                    if (!empty($exclude['nama_item'])) {
                        JeepTripExclude::create([
                            'jeep_trip_id' => $jeepTrip->id,
                            'nama_item' => $exclude['nama_item'],
                        ]);
                    }
                }
            }

            // Handle new images
            if ($request->hasFile('images')) {
                $this->handleImageUploads($jeepTrip, $request->file('images'));
            }

            // Handle slots
            // $jeepTrip->slots()->delete(); // Delete existing slots and their availabilities
            if ($request->has('slots') && is_array($request->slots)) {
                foreach ($request->slots as $slotData) {
                    if (!empty($slotData['nama_slot'])) {
                        JeepTripSlot::updateOrCreate([
                            'jeep_trip_id' => $jeepTrip->id,
                            'nama_slot' => $slotData['nama_slot'],
                        ], [
                            'jam_mulai' => $slotData['jam_mulai'],
                            'jam_selesai' => $slotData['jam_selesai'],
                            'is_active' => $slotData['is_active'] ?? true,
                        ]);
                    }
                }
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Paket Jeep Trip berhasil diperbarui'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating JeepTrip: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat memperbarui paket Jeep Trip'
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $jeepTrip = JeepTrip::findOrFail($id);

            // Delete associated images from storage
            foreach ($jeepTrip->images as $image) {
                Storage::disk('public')->delete($image->image_path);
            }

            $jeepTrip->delete();

            return response()->json([
                'status' => true,
                'message' => 'Paket Jeep Trip berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            Log::error('Error deleting JeepTrip: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat menghapus paket Jeep Trip'
            ], 500);
        }
    }

    private function handleImageUploads(JeepTrip $jeepTrip, array $images)
    {
        $currentImageCount = $jeepTrip->images()->count();

        foreach ($images as $index => $image) {
            if ($image->isValid()) {
                $filename = time() . '_' . $index . '_' . $image->getClientOriginalName();
                $path = $image->storeAs('jeep-trips', $filename, 'public');

                JeepTripImage::create([
                    'jeep_trip_id' => $jeepTrip->id,
                    'image_path' => $path,
                    'judul' => $image->getClientOriginalName(),
                    'urutan' => $currentImageCount + $index + 1,
                ]);
            }
        }
    }
}