<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuratController;

/*
|--------------------------------------------------------------------------
| HOME / ROOT
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    
    return Auth::user()->role === 'pegawai' 
        ? redirect()->route('admin.dashboard')
        : redirect()->route('user.dashboard');
})->name('home');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| DASHBOARD USER (PENDUDUK)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:penduduk'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'penduduk'])
        ->name('user.dashboard');

    // Ajukan Surat
    // Route::get('/surat/create', [SuratController::class, 'create'])->name('surat.create');
    // Route::post('/surat/store', [SuratController::class, 'store'])->name('surat.store');
});

/*
|--------------------------------------------------------------------------
| DASHBOARD ADMIN / PEGAWAI
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->middleware(['auth', 'role:pegawai,admin'])
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('layouts.admin.admin_layout', ['title' => 'Dashboard Admin']);
        })->name('dashboard');

        Route::get('/permohonan', function () {
            return view('layouts.admin.permohonan', ['title' => 'Data Permohonan']);
        })->name('permohonan');

        Route::get('/surat', function () {
            return view('layouts.admin.surat', ['title' => 'Manajemen Surat']);
        })->name('surat');

        Route::get('/rekap', function () {
            return view('layouts.admin.rekap', ['title' => 'Rekap & Laporan']);
        })->name('rekap');

        Route::get('/pengaturan', function () {
            return view('layouts.admin.pengaturan', ['title' => 'Pengaturan Akun']);
        })->name('pengaturan');
});


Route::middleware(['auth', 'role:penduduk'])->group(function () {
    Route::get('/dashboard', function () {
        return view('layouts.app', ['title' => 'Dashboard']);
    })->name('user.dashboard');

    Route::get('/ajukan-surat', function () {
        return view('components.Pengguna.AjukanSurat.ajukan-surat', ['title' => 'Ajukan Surat']);
    })->name('pengajuan.surat');

    Route::get('/riwayat-pengajuan', function () {
        return view('layouts.riwayat_pengajuan', ['title' => 'Riwayat Pengajuan']);
    })->name('riwayat.pengajuan');

    Route::get('/faq', function () {
        return view('layouts.faq', ['title' => 'Bantuan / FAQ']);
    })->name('faq');

    Route::get('/profil-saya', function () {
        return view('layouts.profil', ['title' => 'Profil Saya']);
    })->name('profil.saya');
});