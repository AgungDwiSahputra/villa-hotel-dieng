<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Availability;
use App\Models\Transaksi\Transaksi;
use App\Models\Transaksi\TransaksiDetail;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function show($produk_id)
    {
        $availabilities = TransaksiDetail::select('transaksi_details.*', 'produks.unit as product_unit')
            ->join('produks', 'transaksi_details.produk_id', '=', 'produks.id')
            ->where('transaksi_details.produk_id', $produk_id)
            ->get();
        return response()->json($availabilities);
    }

    public function store(Request $request, $produkId)
    {
        $validatedData = $request->validate([
            'start_date' => 'required',
            'end_date' => 'required',
            'night' => 'required|integer',
            'unit' => 'required|integer',
            'total' => 'required',
            'name' => 'required|string',
            'email' => 'required',
            'no_wa' => 'required',
            'status' => 'required',
        ]);

        $validatedData['order_id'] = (string) \Illuminate\Support\Str::uuid();
        $validatedData['produk_id'] = $produkId;

        try {
            $transaksi = Transaksi::create($validatedData);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }

        $startDate = \Carbon\Carbon::parse($validatedData['start_date']);
        $endDate = \Carbon\Carbon::parse($validatedData['end_date']);
        $unit = $validatedData['unit'];

        for ($date = $startDate; $date->lessThanOrEqualTo($endDate); $date->addDay()) {
            try {
                TransaksiDetail::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id' => $produkId,
                    'date' => $date->format('Y-m-d'),
                    'unit' => $unit,
                    'status' => 'PENDING',
                ]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 422);
            }
        }

        return response()->json([
            'message' => 'Transaksi created successfully.',
            'transaksi' => $transaksi
        ], 201);
    }

    public function update(Request $request, $produkId)
    {
        $validatedData = $request->validate([
            'start_date' => 'required',
            'end_date' => 'required',
            'night' => 'required|integer',
            'unit' => 'required|integer',
            'total' => 'required',
            'name' => 'required|string',
            'email' => 'required',
            'no_wa' => 'required',
            'status' => 'required',
        ]);

        $validatedData['produk_id'] = $produkId;

        $transaksi = Transaksi::where('produk_id', $produkId)
            ->where('name', $validatedData['name'])
            ->where('start_date', $validatedData['start_date'])
            ->where('end_date', $validatedData['end_date'])
            ->where('unit', $validatedData['unit'])
            ->where('status', $validatedData['status'])
            ->first();

        if (!$transaksi) {
            return response()->json(['error' => 'Transaksi not found.'], 404);
        }

        try {
            $transaksi->update($validatedData);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }

        $startDate = \Carbon\Carbon::parse($validatedData['start_date']);
        $endDate = \Carbon\Carbon::parse($validatedData['end_date']);
        $unit = $validatedData['unit'];

        $transaksiDetails = TransaksiDetail::where('transaksi_id', $transaksi->id)->get();

        for ($date = $startDate; $date->lessThanOrEqualTo($endDate); $date->addDay()) {
            $transaksiDetail = $transaksiDetails->firstWhere('date', $date->format('Y-m-d'));

            if ($transaksiDetail) {
                try {
                    $transaksiDetail->update([
                        'unit' => $unit,
                        'date' => $date->format('Y-m-d'),
                    ]);
                } catch (\Exception $e) {
                    return response()->json(['error' => $e->getMessage()], 422);
                }
            } else {
                try {
                    TransaksiDetail::create([
                        'transaksi_id' => $transaksi->id,
                        'produk_id' => $produkId,
                        'date' => $date->format('Y-m-d'),
                        'unit' => $unit,
                        'status' => 'PENDING',
                    ]);
                } catch (\Exception $e) {
                    return response()->json(['error' => $e->getMessage()], 422);
                }
            }
        }

        return response()->json([
            'message' => 'Transaksi updated successfully.',
            'transaksi' => $transaksi
        ], 200);
    }

    public function destroy($produk_id, $id)
    {
        $availability = Availability::where('produk_id', $produk_id)->where('id', $id)->firstOrFail();
        $availability->delete();

        return response()->json(['message' => 'Event deleted successfully.']);
    }
}

