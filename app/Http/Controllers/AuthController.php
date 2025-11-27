<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $r)
    {
        $r->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|unique:users|max:255',
            'password' => 'required|string|min:6|confirmed',
            'nik' => 'required|string|unique:users|digits:16',
            'tanggal_lahir' => 'required|date|before:today',
            'no_wa' => 'required|string|regex:/^[0-9]{10,15}$/'
        ], [
            'nik.digits' => 'NIK harus 16 digit',
            'no_wa.regex' => 'Nomor WhatsApp tidak valid',
            'tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini',
            'password.confirmed' => 'Konfirmasi password tidak cocok'
        ]);

        try {
            $user = User::create([
                'nama' => $r->nama,
                'username' => $r->username,
                'password' => Hash::make($r->password),
                'nik' => $r->nik,
                'tanggal_lahir' => $r->tanggal_lahir,
                'no_wa' => $r->no_wa,
                'role' => 'penduduk'
            ]);

            // Redirect ke login dengan pesan sukses
            return redirect()->route('login')
                ->with('success', 'Registrasi berhasil! Silakan login dengan akun Anda.');
                
        } catch (\Exception $e) {
            return back()
                ->withInput($r->except('password', 'password_confirmation'))
                ->with('error', 'Terjadi kesalahan saat registrasi. Silakan coba lagi.');
        }
    }

    public function login(Request $r)
    {
        $r->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ], [
            'username.required' => 'Username wajib diisi',
            'password.required' => 'Password wajib diisi'
        ]);

        // Cek apakah user ada
        $user = User::where('username', $r->username)->first();
        
        if (!$user) {
            return back()
                ->withInput($r->only('username'))
                ->with('error', 'Username tidak ditemukan!');
        }

        // Attempt login
        if (Auth::attempt($r->only('username', 'password'), $r->filled('remember'))) {
            $r->session()->regenerate();

            // Redirect berdasarkan role
            $redirectRoute = auth()->user()->role === 'pegawai'
                ? 'admin.dashboard'
                : 'user.dashboard';

            return redirect()->route($redirectRoute)
                ->with('success', 'Selamat datang, ' . auth()->user()->nama . '!');
        }

        // Password salah
        return back()
            ->withInput($r->only('username'))
            ->with('error', 'Password salah!');
    }

    public function logout(Request $r)
    {
        $userName = auth()->user()->nama; // Simpan nama sebelum logout
        
        Auth::logout();
        $r->session()->invalidate();
        $r->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda telah logout. Sampai jumpa, ' . $userName . '!');
    }
}