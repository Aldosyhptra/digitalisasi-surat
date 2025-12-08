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

    // 1. Halaman Pilih Jenis Surat
    Route::get('/ajukan-surat', [SuratController::class, 'pilihSurat'])
        ->name('pengajuan.surat');
    
    // 2. Form Pengajuan Surat (dinamis)
    Route::get('/ajukan-surat/form/{id}', [SuratController::class, 'formAjukan'])
        ->name('ajukan-surat.form');
    
    // 3. Submit Pengajuan
    Route::post('/ajukan-surat/submit', [SuratController::class, 'submitAjukan'])
        ->name('ajukan-surat.submit');

    Route::get('/surat/{id}/preview', [SuratController::class, 'previewSurat'])
        ->name('surat.preview');
    
    // 4. Riwayat Pengajuan (List)
    Route::get('/riwayat-pengajuan', [SuratController::class, 'riwayatSurat'])
        ->name('riwayat.pengajuan');
    
    // 5. Detail Pengajuan
    Route::get('/riwayat-pengajuan/detail/{id}', [SuratController::class, 'detailSurat'])
        ->name('riwayat-pengajuan.detail');
    
    // 6. Download Surat (yang sudah disetujui)
    Route::get('/surat/download/{id}', [SuratController::class, 'downloadSurat'])
        ->name('surat.download');

    // Store surat (jika ada kebutuhan tambahan)
    Route::post('/surat/store', [SuratController::class, 'store'])
        ->name('surat.store');
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

        // Tampilkan semua surat
        Route::get('/surat', [SuratController::class, 'showAllSurat'])->name('surat');

        Route::post('/jenis-surat/store', [SuratController::class, 'storeJenisSurat'])->name('jenis_surat.store');

        // Form upload template
        Route::get('/surat/upload_surat', [SuratController::class, 'showUploadForm'])->name('surat.upload_form');

        // Proses upload
        Route::post('/surat/upload', [SuratController::class, 'upload'])->name('surat.upload');

        // Update template
        Route::put('/surat/update/{id}', [SuratController::class, 'update'])->name('surat.update');

        // Hapus template
        Route::delete('/surat/hapus/{id}', [SuratController::class, 'hapus'])->name('surat.hapus');

        // Generate surat
        Route::post('/surat/generate/{id}', [SuratController::class, 'generate'])->name('surat.generate');

        Route::get('/permohonan', [SuratController::class, 'permohonanSuratPengguna'])
        ->name('permohonan');   

        Route::get('/rekap', function () {
            return view('layouts.admin.rekap', ['title' => 'Rekap & Laporan']);
        })->name('rekap');

        Route::get('/pengaturan', function () {
            return view('layouts.admin.pengaturan', ['title' => 'Pengaturan Akun']);
        })->name('pengaturan');

        Route::get('/riwayat-pengajuan/detail/{id}', 
            [SuratController::class, 'detailSurat']
        )->name('riwayat-pengajuan.detail');
    });

    