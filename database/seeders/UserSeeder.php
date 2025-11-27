<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nama'           => 'Admin Sistem contoh',
            'username'       => 'admin',
            'password'       => Hash::make('admin123'), // ganti sesuai kebutuhan
            'nik'            => '3201123456789012',      // 16 digit
            'tanggal_lahir'  => '1990-01-01',
            'no_wa'          => '081234567890',          // 10–15 digit
            'role'           => 'admin'
        ]);

        User::create([
            'nama'           => 'penduduk Contoh',
            'username'       => 'penduduk',
            'password'       => Hash::make('penduduk123'),
            'nik'            => '3201123456789013',
            'tanggal_lahir'  => '1995-05-10',
            'no_wa'          => '081298765432',
            'role'           => 'penduduk'
        ]);
    }
}
