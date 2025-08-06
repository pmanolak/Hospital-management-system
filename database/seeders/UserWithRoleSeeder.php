<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserWithRoleSeeder extends Seeder
{
    public function run()
    {
        // Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@hospital.com'],
            ['name' => 'Admin User', 'password' => Hash::make('password')]
        );
        $admin->assignRole('Admin');

        // Doctor User
        $doctor = User::firstOrCreate(
            ['email' => 'doctor@hospital.com'],
            ['name' => 'Dr. Smith', 'password' => Hash::make('password')]
        );
        $doctor->assignRole('Doctor');

        // Receptionist User
        $receptionist = User::firstOrCreate(
            ['email' => 'reception@hospital.com'],
            ['name' => 'Receptionist Jane', 'password' => Hash::make('password')]
        );
        $receptionist->assignRole('Receptionist');

        // Pharmacist User
        $pharmacist = User::firstOrCreate(
            ['email' => 'pharmacist@hospital.com'],
            ['name' => 'Pharmacist Ali', 'password' => Hash::make('password')]
        );
        $pharmacist->assignRole('Pharmacist');

        // Patient User
        $patient = User::firstOrCreate(
            ['email' => 'patient@hospital.com'],
            ['name' => 'Patient John', 'password' => Hash::make('password')]
        );
        $patient->assignRole('Patient');
    }
}
