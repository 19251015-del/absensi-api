<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('password123');

        // 1. Admin Sistem
        User::create([
            'employee_id' => 'ADM001',
            'name' => 'Admin Sistem',
            'email' => 'admin@absensiku.id',
            'password' => $password,
            'role' => 'admin',
        ]);

        // 2. Data Karyawan sesuai Frontend
        $employees = [
            [
                'employee_id' => 'EMP001',
                'name' => 'Dimas Pratama',
                'email' => 'dimas@absensiku.id',
                'password' => $password,
                'role' => 'employee',
            ],
            [
                'employee_id' => 'EMP002',
                'name' => 'Alya Rahma',
                'email' => 'alya@absensiku.id',
                'password' => $password,
                'role' => 'employee',
            ],
            [
                'employee_id' => 'EMP003',
                'name' => 'Raka Putra',
                'email' => 'raka@absensiku.id',
                'password' => $password,
                'role' => 'employee',
            ],
            [
                'employee_id' => 'EMP004',
                'name' => 'Nadia Sari',
                'email' => 'nadia@absensiku.id',
                'password' => $password,
                'role' => 'employee',
            ],
            [
                'employee_id' => 'EMP005',
                'name' => 'Amar Maulana',
                'email' => 'ngabs@absensiku.id',
                'password' => $password,
                'role' => 'employee',
            ],
        ];

        foreach ($employees as $employee) {
            User::create($employee);
        }
    }
}