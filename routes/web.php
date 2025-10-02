<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DosenController as AdminDosenController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\TrashController;
use App\Http\Controllers\Admin\ProgramStudiController; // <-- Controller baru
use App\Http\Controllers\Admin\JenisPkmController;      // <-- Controller baru
use App\Http\Controllers\DosenController;

/*
|--------------------------------------------------------------------------
| Rute Dosen (Halaman Depan Publik)
|--------------------------------------------------------------------------
*/
Route::get('/', [DosenController::class, 'create'])->name('dosen.form.create');
Route::post('/jurnal-dosen', [DosenController::class, 'storeJurnal'])->name('dosen.form.store.jurnal');
Route::post('/pkm-dosen', [DosenController::class, 'storePkm'])->name('dosen.form.store.pkm');
Route::get('/success', function () { return view('dosen.sukses'); })->name('dosen.success');

/*
|--------------------------------------------------------------------------
| Rute Admin (Panel Admin)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    // Rute untuk tamu (belum login)
    Route::middleware('guest')->group(function () {
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    });

    // Rute untuk admin yang sudah login
    Route::middleware('auth:admin')->group(function() {
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // --- Rute Khusus Superadmin ---
        Route::middleware('can:manage-admins')->group(function () {
            // Rute Laporan
            Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

            // Rute Kelola Admin (CRUD)
            Route::resource('admins', AdminController::class)->except(['show']);

            // Rute Tempat Sampah Terpusat
            Route::prefix('trash')->name('trash.')->group(function () {
                Route::get('/', [TrashController::class, 'index'])->name('index');
                Route::post('/restore/{type}/{id}', [TrashController::class, 'restore'])->name('restore');
                Route::delete('/force-delete/{type}/{id}', [TrashController::class, 'forceDelete'])->name('forceDelete');
            });

            // RUTE BARU UNTUK KELOLA PROGRAM STUDI
            Route::resource('program-studi', ProgramStudiController::class)->except(['show', 'create']);

            // RUTE BARU UNTUK KELOLA JENIS PKM
            Route::resource('jenis-pkm', JenisPkmController::class)->except(['show', 'create']);
        });
        
        // --- Rute Untuk Semua Admin ---
        // Rute Kelola Dosen (CRUD)
        Route::resource('dosen', AdminDosenController::class);
    });
});