<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas  = [
            'User Management Role (Permission)',
            'Setting Apps (Index)',
            'Activity Log (Index)',
            'Activity Log (Delete)',
            'promo view',
            'promo create',
            'promo edit',
            'promo delete',
        ];

        $moduls  = [
            'Produk',
            'Produk Category',
            'Produk Image',
            'Produk Fasilitas',
            'Produk Wisata',
            'Produk Syarat',
            'Jeep Trip',
            'Jeep Trip Image',
            'Jeep Trip Availability',
            'Transaksi',
            'Rekening',
            'User Management User',
            'User Management Role',
            'User Management Permission',
        ];

        $actions = ['Index','Create','Edit','Delete'];
        foreach($moduls as $modul){
            foreach($actions as $action)
            {
                $datas[] = $modul.' ('.$action.')';
            }
        }

        // Insert permissions hanya jika belum ada
        foreach($datas as $data)
        {
            Permission::firstOrCreate([
                'name' => $data
            ]);
        }
        
        // Buat role Super Admin hanya jika belum ada
        $role = Role::firstOrCreate(['name' => 'Super Admin']);
        $role->syncPermissions($datas);
    }
}
