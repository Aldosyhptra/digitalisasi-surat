<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{
    public function show()
{
    $user = Auth::user();
    return view('layouts.profil', compact('user'));
}

  public function update(Request $request)
{
    $user = Auth::user();

    $validated = $request->validate([
        'nama'           => 'nullable|string|max:255',
        'username'       => 'nullable|string|max:255|unique:users,username,' . $user->id,
        'email'          => 'nullable|email|unique:users,email,' . $user->id,
        'nik'            => 'nullable|string|max:20',
        'tanggal_lahir'  => 'nullable|date',
        'jenis_kelamin'  => 'nullable|in:laki-laki,perempuan',
        'alamat'         => 'nullable|string|max:255',
        'no_wa'          => 'nullable|string|max:20',
        'bio'            => 'nullable|string',
        'foto'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'password'       => 'nullable|string|min:6|confirmed',
    ]);

    // Update field biasa
    foreach ([
        'nama','username','email','nik','tanggal_lahir',
        'jenis_kelamin','alamat','no_wa','bio'
    ] as $field) {
        if ($request->filled($field)) {
            $user->$field = $request->$field;
        }
    }

    // Update foto - INI YANG DIPERBAIKI
    if ($request->hasFile('foto')) {
        // Hapus foto lama jika ada - PATH DIPERBAIKI
        if ($user->foto && Storage::disk('public')->exists('foto/' . $user->foto)) {
            Storage::disk('public')->delete('foto/' . $user->foto);
        }

        // Generate nama file
        $file = $request->file('foto');
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        // Simpan ke storage/app/public/foto
        $file->storeAs('foto', $filename, 'public');

        // Simpan nama file ke database
        $user->foto = $filename;
    }

    // Update password
    if ($request->filled('password')) {
        $user->password = Hash::make($validated['password']);
    }

    $user->save();

    return redirect()->route('profil.saya')->with('success', 'Profil berhasil diperbarui!');
}

}
