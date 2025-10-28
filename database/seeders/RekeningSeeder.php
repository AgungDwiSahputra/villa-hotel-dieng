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
        // Buat folder jika belum ada
        $rekeningDir = storage_path('app/public/images/rekening');
        if (!File::exists($rekeningDir)) {
            File::makeDirectory($rekeningDir, 0755, true);
        }

        $banks = [
            ['bank' => 'BNI',     'name' => 'Sun Flower Hotel & Villa', 'no_rekening' => '1234567890', 'image' => 'bni.png'],
            ['bank' => 'BCA',     'name' => 'Sun Flower Hotel & Villa', 'no_rekening' => '2345678901', 'image' => 'bca.png'],
            ['bank' => 'BRI',     'name' => 'Sun Flower Hotel & Villa', 'no_rekening' => '3456789012', 'image' => 'bri.png'],
            ['bank' => 'BSI',     'name' => 'Sun Flower Hotel & Villa', 'no_rekening' => '4567890123', 'image' => 'bsi.png'],
            ['bank' => 'Mandiri', 'name' => 'Sun Flower Hotel & Villa', 'no_rekening' => '5678901234', 'image' => 'mandiri.png'],
            ['bank' => 'Mega',    'name' => 'Sun Flower Hotel & Villa', 'no_rekening' => '6789012345', 'image' => 'mega.png'],
        ];

        foreach ($banks as $bank) {
            $sourcePath      = public_path('template/rekening/' . $bank['image']);
            $destinationPath = storage_path('app/public/images/rekening/' . $bank['image']);

            // Salin file jika belum ada di tujuan
            if (!File::exists($destinationPath)) {
                File::copy($sourcePath, $destinationPath);
            }

            // Gunakan updateOrCreate untuk menghindari duplikasi
            Rekening::updateOrCreate(
                ['no_rekening' => $bank['no_rekening']], // unique identifier
                [
                    'bank'         => $bank['bank'],
                    'name'         => $bank['name'],
                    'image'        => 'images/rekening/' . $bank['image'],
                ]
            );
        }
    }
}