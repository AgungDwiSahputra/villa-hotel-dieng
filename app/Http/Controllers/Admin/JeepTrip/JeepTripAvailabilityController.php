<?php

namespace App\Http\Controllers\Admin\JeepTrip;

use App\DataTables\Admin\JeepTrip\JeepTripAvailabilityDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\JeepTrip\JeepTripAvailabilityRequest;
use App\Models\JeepTrip\JeepTripAvailability;
use App\Models\JeepTrip\JeepTripSlot;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class JeepTripAvailabilityController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:Jeep Trip Availability (Index)', only: ['index']),
            new Middleware('permission:Jeep Trip Availability (Create)', only: ['store']),
            new Middleware('permission:Jeep Trip Availability (Edit)', only: ['edit', 'update']),
            new Middleware('permission:Jeep Trip Availability (Delete)', only: ['destroy']),
        ];
    }

    public function index(JeepTripAvailabilityDataTable $dataTable)
    {
        $slots = JeepTripSlot::with('jeepTrip')->active()->get()->map(function ($slot) {
            return (object) [
                'id' => $slot->id,
                'name' => $slot->jeepTrip->nama_paket . ' - ' . $slot->nama_slot . ' (' . $slot->getFormattedTimeRange() . ')'
            ];
        });
        return $dataTable->render('admin.jeep-trip.availability.index', compact('slots'));
    }


    public function store(JeepTripAvailabilityRequest $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validated();

            // Check if availability already exists for this slot and date
            $existing = JeepTripAvailability::where('jeep_trip_slot_id', $validated['jeep_trip_slot_id'])
                ->where('tanggal', $validated['tanggal'])
                ->first();

            if ($existing) {
                return response()->json([
                    'status' => false,
                    'message' => 'Availability untuk slot dan tanggal ini sudah ada'
                ], 422);
            }

            // Create availability
            JeepTripAvailability::create($validated);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Availability Jeep Trip berhasil dibuat'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating JeepTripAvailability: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat membuat availability Jeep Trip'
            ], 500);
        }
    }

    public function show(string $id)
    {
        $availability = JeepTripAvailability::with(['slot.jeepTrip'])->findOrFail($id);
        return view('admin.jeep-trip.availability.show', compact('availability'));
    }

    public function edit(string $id)
    {
        $availability = JeepTripAvailability::with(['slot.jeepTrip'])->findOrFail($id);
        $slots = JeepTripSlot::with('jeepTrip')->active()->get()->map(function ($slot) {
            return (object) [
                'id' => $slot->id,
                'name' => $slot->jeepTrip->nama_paket . ' - ' . $slot->nama_slot . ' (' . $slot->getFormattedTimeRange() . ')'
            ];
        });

        // Format data untuk frontend
        $formattedData = [
            'id' => $availability->id,
            'jeep_trip_slot_id' => $availability->jeep_trip_slot_id,
            'tanggal' => $availability->tanggal ? $availability->tanggal->format('Y-m-d') : null,
            'quota_jeep' => $availability->quota_jeep,
            'quota_terpakai' => $availability->quota_terpakai,
            'is_closed' => $availability->is_closed,
            'created_at' => $availability->created_at,
            'updated_at' => $availability->updated_at,
        ];

        return response()->json([
            'data' => $formattedData,
            'slots' => $slots
        ]);
    }

    public function update(JeepTripAvailabilityRequest $request, string $id)
    {
        try {
            DB::beginTransaction();

            $availability = JeepTripAvailability::findOrFail($id);
            $validated = $request->validated();

            // Check if another availability exists for this slot and date (excluding current)
            $existing = JeepTripAvailability::where('jeep_trip_slot_id', $validated['jeep_trip_slot_id'])
                ->where('tanggal', $validated['tanggal'])
                ->where('id', '!=', $id)
                ->first();

            if ($existing) {
                return response()->json([
                    'status' => false,
                    'message' => 'Availability untuk slot dan tanggal ini sudah ada'
                ], 422);
            }

            // Prevent reducing quota below already booked amount
            if ($validated['quota_jeep'] < $availability->quota_terpakai) {
                return response()->json([
                    'status' => false,
                    'message' => 'Quota jeep tidak boleh kurang dari jumlah yang sudah terpakai (' . $availability->quota_terpakai . ')'
                ], 422);
            }

            // Update availability
            $availability->update($validated);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Availability Jeep Trip berhasil diperbarui'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating JeepTripAvailability: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat memperbarui availability Jeep Trip'
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $availability = JeepTripAvailability::findOrFail($id);

            // Check if there are active bookings
            if ($availability->quota_terpakai > 0) {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak dapat menghapus availability yang masih memiliki booking aktif'
                ], 422);
            }

            $availability->delete();

            return response()->json([
                'status' => true,
                'message' => 'Availability Jeep Trip berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            Log::error('Error deleting JeepTripAvailability: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat menghapus availability Jeep Trip'
            ], 500);
        }
    }
}