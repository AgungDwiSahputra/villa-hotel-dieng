<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $sourcePath      = public_path('template/icon.png');
        $destinationPath = storage_path('app/public/images/setting/icon.png');
        File::copy($sourcePath, $destinationPath);

        $sourcePath      = public_path('template/logo.png');
        $destinationPath = storage_path('app/public/images/setting/logo.png');
        File::copy($sourcePath, $destinationPath);

        $datas = [
            'name'          => 'Sun Flower Hotel & Villa',
            'company'       => 'Developer Digital by Cv. Dekreatif',
            'theme'         => '#1F305A',
            'header'        => '#1F305A',
            'icon_size'     => '35',
            'logo_size'     => '45',
            'icon'          => 'images/setting/icon.png',
            'logo'          => 'images/setting/logo.png',
            'dp'            => '25',

            'contact_email'   => 'info@sunflower.com',
            'contact_phone'   => '082162622680',
            'contact_address' => 'Jl Padang Indah, Padangsambian Kec. Denpasan Kota Denpasar Bali',

            'sosmed_whatsapp'  => 'https://wa.me/6282162622680',
            'sosmed_instagram' => '#',
            'sosmed_facebook'  => '#',
            'sosmed_tiktok'    => '#',
            'sosmed_youtube'   => '#',

            'page_about' => '
                <p>Sun Flower Hotel & Villa adalah penginapan yang menawarkan kenyamanan dan kemewahan di tengah suasana tropis Bali.</p>
                <p>Kami menghadirkan pengalaman menginap yang tak terlupakan dengan fasilitas lengkap dan pelayanan ramah.</p>
                <p>Dengan lokasi strategis di pusat kota Denpasar, kami siap menyambut Anda baik untuk liburan maupun keperluan bisnis.</p>
            ',

            'page_terms' => '
                <p>Dengan menggunakan layanan kami, Anda setuju untuk mematuhi semua syarat dan ketentuan yang berlaku.</p>
                <p>Pemesanan yang telah dilakukan tidak dapat dibatalkan secara sepihak tanpa persetujuan dari pihak hotel.</p>
                <p>Semua informasi pribadi yang Anda berikan akan kami jaga kerahasiaannya sesuai dengan kebijakan privasi kami.</p>
            ',
        ];

        foreach ($datas as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $mails = Setting::where('key', 'like', '%mail%')->get();
        $envFilePath = base_path('.env');
        $envContent = File::get($envFilePath);

        foreach ($mails as $mail) {
            $envKey     = strtoupper($mail->key);
            $envValue = '"' . $mail->value . '"';
            $envContent = preg_replace("/^{$envKey}=.*$/m", "{$envKey}={$envValue}", $envContent);
        }

        File::put($envFilePath, $envContent);
    }
}
