<?php

namespace Database\Seeders;

use App\Models\Rekening;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class RekeningSeeder extends Seeder
{
    public function run(): void
    {
        $banks = [
            ['bank' => 'BNI',     'name' => 'Sun Flower Hotel & Villa', 'no_rekening' => '1234567890', 'image' => 'bni.png'],
            ['bank' => 'BCA',     'name' => 'Sun Flower Hotel & Villa', 'no_rekening' => '2345678901', 'image' => 'bca.png'],
            ['bank' => 'BRI',     'name' => 'Sun Flower Hotel & Villa', 'no_rekening' => '3456789012', 'image' => 'bri.png'],
            ['bank' => 'BSI',     'name' => 'Sun Flower Hotel & Villa', 'no_rekening' => '4567890123', 'image' => 'bsi.png'],
            ['bank' => 'Mandiri', 'name' => 'Sun Flower Hotel & Villa', 'no_rekening' => '5678901234', 'image' => 'mandiri.png'],
            ['bank' => 'Mega',    'name' => 'Sun Flower Hotel & Villa', 'no_rekening' => '6789012345', 'image' => 'mega.png'],
        ];

        $datas = [];

        foreach ($banks as $bank) {
            $sourcePath      = public_path('template/rekening/' . $bank['image']);
            $destinationPath = storage_path('app/public/images/rekening/' . $bank['image']);

            // Salin file jika belum ada di tujuan
            if (!File::exists($destinationPath)) {
                File::copy($sourcePath, $destinationPath);
            }

            $datas[] = [
                'id'           => (string) Str::uuid(),
                'bank'         => $bank['bank'],
                'name'         => $bank['name'],
                'no_rekening'  => $bank['no_rekening'],
                'image'        => 'images/rekening/' . $bank['image'],
            ];
        }

        Rekening::insert($datas);
    }
}