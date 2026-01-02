<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Bikin Akun Admin (Ini buat kamu login)
        User::create([
            'nama_lengkap' => 'Reza Administrator',
            'username' => 'admin',
            'password' => Hash::make('admin123'), // Passwordnya: admin123
            'role' => 'admin',
        ]);

        // 2. Bikin Akun Siswa (Contoh)
        User::create([
            'nama_lengkap' => 'Budi Santoso',
            'username' => 'budi',
            'password' => Hash::make('siswa123'), // Passwordnya: siswa123
            'role' => 'siswa',
        ]);
    }
}