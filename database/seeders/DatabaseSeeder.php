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
        ]);

        $sourcePath      = public_path('template/icon.png');
        $destinationPath = storage_path('app/public/images/user/super_admin.png');
        File::copy($sourcePath, $destinationPath);
        
        $user = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password'),
            'role' => 'Super Admin',
            'image' => 'images/user/super_admin.png',
        ]);
        $user->assignRole('Super Admin');
    }   
}
