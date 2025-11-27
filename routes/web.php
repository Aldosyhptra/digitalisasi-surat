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
    ->middleware(['auth', 'role:pegawai'])
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])
            ->name('dashboard');

        // Route::get('/permohonan', [SuratController::class, 'indexForPegawai'])
        //     ->name('permohonan');
        // Route::post('/surat/{surat}/approve', [SuratController::class, 'approve'])
        //     ->name('surat.approve');
        // Route::post('/surat/{surat}/selesai', [SuratController::class, 'markSelesai'])
        //     ->name('surat.selesai');
        // Route::post('/surat/{surat}/revisi', [SuratController::class, 'requestRevision'])
        //     ->name('surat.revisi');
    });