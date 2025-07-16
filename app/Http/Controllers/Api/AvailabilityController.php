<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Availability;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function show($produk_id)
    {
        $availabilities = Availability::where('produk_id', $produk_id)->get();
        return response()->json($availabilities);
    }

    public function update(Request $request, $produk_id)
    {
        $data = $request->validate([
            'dates' => 'required|array',
            'dates.*.id_calendar' => 'required',
            'dates.*.date' => 'required|date',
            'dates.*.is_available' => 'required|boolean',
        ]);

        if (empty($data['dates']) || count($data['dates']) < 0) {
            return response()->json(['message' => 'Harus memilih 2 tanggal.'], 404);
        }

        foreach ($data['dates'] as $entry) {
            $availability = Availability::updateOrCreate(
                [
                    'produk_id' => $produk_id,
                    'date' => $entry['date']
                ],
                [
                    'id_calendar' => $entry['id_calendar'], 
                    'is_available' => $entry['is_available']
                ]
            );
        }

        return response()->json(['message' => 'Availability updated.']);
    }

    public function destroy($produk_id, $id)
    {
        $availability = Availability::where('produk_id', $produk_id)->where('id', $id)->firstOrFail();
        $availability->delete();

        return response()->json(['message' => 'Event deleted successfully.']);
    }
}

