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
        'nama'           => 'Admin Sistem Contoh',
        'username'       => 'admin',
        'email'          => 'admin@example.com',
        'password'       => Hash::make('admin123'),
        'nik'            => '3201123456789012',
        'tanggal_lahir'  => '1990-01-01',
        'jenis_kelamin'  => 'laki-laki', 
        'alamat'         => 'Jl. Contoh No. 1',
        'no_wa'          => '081234567890',
        'role'           => 'admin',
        'bio'            => 'Saya adalah administrator.',
        'foto'    => null             
    ]);

    User::create([
        'nama'           => 'Penduduk Contoh',
        'username'       => 'penduduk',
        'email'          => 'penduduk@example.com',
        'password'       => Hash::make('penduduk123'),
        'nik'            => '3201123456789013',
        'tanggal_lahir'  => '1995-05-10',
        'jenis_kelamin'  => 'perempuan',    
        'alamat'         => 'Jl. Melati No. 5',
        'no_wa'          => '081298765432',
        'role'           => 'penduduk',
        'bio'            => 'Saya adalah pengguna biasa.',
        'foto'    => null
    ]);
}

}
