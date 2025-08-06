<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            'manage patients',
            'manage doctors',
            'manage appointments',
            'create prescriptions',
            'manage inventory',
            'view billing',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        Role::firstOrCreate(['name' => 'Admin'])
            ->givePermissionTo(Permission::all());

        Role::firstOrCreate(['name' => 'Doctor'])
            ->givePermissionTo(['manage appointments', 'create prescriptions']);

        Role::firstOrCreate(['name' => 'Receptionist'])
            ->givePermissionTo(['manage appointments']);

        Role::firstOrCreate(['name' => 'Pharmacist'])
            ->givePermissionTo(['manage inventory']);

        Role::firstOrCreate(['name' => 'Patient']);  
    }
}
