<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrator Sistem',
            'email' => 'admin@inventaris.test',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Petugas Inventaris',
            'email' => 'petugas@inventaris.test',
            'password' => Hash::make('password123'),
            'role' => 'petugas',
        ]);

        User::create([
            'name' => 'Mahasiswa Peminjam',
            'email' => 'peminjam@inventaris.test',
            'password' => Hash::make('password123'),
            'role' => 'peminjam',
        ]);
    }
}