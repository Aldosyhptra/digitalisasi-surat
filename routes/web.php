<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\ProfileController;

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

    Route::get('/ajukan-surat', function () {
        return view('components.Pengguna.AjukanSurat.ajukan-surat', ['title' => 'Ajukan Surat']);
    })->name('pengajuan.surat');

    Route::get('/riwayat-pengajuan', function () {
        return view('layouts.riwayat_pengajuan', ['title' => 'Riwayat Pengajuan']);
    })->name('riwayat.pengajuan');

    Route::get('/faq', function () {
        return view('layouts.faq', ['title' => 'Bantuan / FAQ']);
    })->name('faq');

    Route::get('/profil-saya', [ProfileController::class, 'show'])
    ->middleware(['auth'])
    ->name('profil.saya');

    Route::get('/profil-saya/edit', function () {
        return view('components.Pengguna.Profil.edit_profil', ['title' => 'Edit Profil']);
    })->name('profil.edit');

    Route::post('/profil-saya/update', [ProfileController::class, 'update'])
        ->name('profil.update');

    Route::post('/surat/store', [SuratController::class, 'store'])
        ->name('surat.store');
});

/*
|--------------------------------------------------------------------------
| PENDUDUK - ROUTE BEBAS (TANPA NAME)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:penduduk'])->group(function () {
    Route::get('/pengguna/ajukan-surat/form_template', function () {
        return view('components.pengguna.ajukansurat.form_template');
    });

    Route::get('/riwayat-pengajuan/detail/{no}', function ($no) {
        return view('components.Pengguna.RiwayatPengajuan.detail_pengajuan', compact('no'));
    });
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
            return view('components.admin.dashboard.dashboard', ['title' => 'Dashboard Admin']);
        })->name('dashboard');

        // ✅ Tampilkan semua surat
        Route::get('/surat', [SuratController::class, 'showAllSurat'])->name('surat');

        Route::post('/jenis-surat/store', [SuratController::class, 'storeJenisSurat'])->name('jenis_surat.store');

        // ✅ Form upload template
        Route::get('/surat/upload_surat', [SuratController::class, 'showUploadForm'])->name('surat.upload_form');

        // ✅ Proses upload
        Route::post('/surat/upload', [SuratController::class, 'upload'])->name('surat.upload');

        // ✅ Update template
        Route::put('/surat/update/{id}', [SuratController::class, 'update'])->name('surat.update');

        // ✅ Hapus template
        Route::delete('/surat/hapus/{id}', [SuratController::class, 'hapus'])->name('surat.hapus');

        // ✅ Generate surat
        Route::post('/surat/generate/{id}', [SuratController::class, 'generate'])->name('surat.generate');

        Route::get('/permohonan', function () {
            return view('layouts.admin.permohonan', ['title' => 'Data Permohonan']);
        })->name('permohonan');

        Route::get('/rekap', function () {
            return view('layouts.admin.rekap', ['title' => 'Rekap & Laporan']);
        })->name('rekap');

        Route::get('/pengaturan', function () {
            return view('layouts.admin.pengaturan', ['title' => 'Pengaturan Akun']);
        })->name('pengaturan');


        Route::post('/jenis-surat/{id}/upload-template',
            [SuratController::class, 'uploadTemplate']
        )->name('upload.template');


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
Route::get('/pengguna/ajukan-surat/form_template', function () {
    return view('components.pengguna.ajukansurat.form_template');
});
Route::get('/riwayat-pengajuan/detail/{no}', function($no) {
    return view('components.Pengguna.RiwayatPengajuan.detail_pengajuan', compact('no'));
});
    Route::get('/profil-saya/edit', function () {
        return view('components.Pengguna.Profil.edit_profil', ['title' => 'Edit Profil']);
    })->name('profil.edit');

        Route::get('/surat/{id}/generate',
            [SuratController::class, 'generateSurat']
        )->name('generate.surat');
    });