<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            SettingSeeder::class,
            RekeningSeeder::class,
            Produk\ProdukCategorySeeder::class,
            Produk\ProdukSeeder::class,
            JeepTripSeeder::class,
            TransaksiSeeder::class,
        ]);

        // Buat folder user jika belum ada
        $userDir = storage_path('app/public/images/user');
        if (!File::exists($userDir)) {
            File::makeDirectory($userDir, 0755, true);
        }

        $sourcePath      = public_path('template/icon.png');
        $destinationPath = storage_path('app/public/images/user/super_admin.png');
        
        // Salin file hanya jika belum ada di tujuan
        if (!File::exists($destinationPath)) {
            File::copy($sourcePath, $destinationPath);
        }
        
        // Buat user Super Admin hanya jika belum ada
        $user = User::updateOrCreate(
            ['email' => 'admin@mail.com'], // unique identifier
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => 'Super Admin',
                'image' => 'images/user/super_admin.png',
            ]
        );
        $user->assignRole('Super Admin');
    }
}
