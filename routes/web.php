<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DosenController as AdminDosenController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\TrashController;
use App\Http\Controllers\Admin\ProgramStudiController;
use App\Http\Controllers\Admin\JenisPkmController;
use App\Http\Controllers\DosenController;

/*
|--------------------------------------------------------------------------
| Rute Dosen (Halaman Depan Publik)
|--------------------------------------------------------------------------
*/
Route::get('/', [DosenController::class, 'create'])->name('dosen.form.create');
Route::post('/jurnal-dosen', [DosenController::class, 'storeJurnal'])->name('dosen.form.store.jurnal');
Route::post('/pkm-dosen', [DosenController::class, 'storePkm'])->name('dosen.form.store.pkm');
Route::get('/success', function () {
    return view('dosen.sukses');
})->name('dosen.success');

/*
|--------------------------------------------------------------------------
| Rute Admin (Panel Admin)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    // --- RUTE UNTUK TAMU (BELUM LOGIN) ---
    Route::middleware('guest')->group(function () {
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    });

    // --- RUTE UNTUK ADMIN YANG SUDAH LOGIN ---
    Route::middleware('auth:admin')->group(function () {
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | RUTE KHUSUS SUPERADMIN
        |--------------------------------------------------------------------------
        */
        Route::middleware('can:manage-admins')->group(function () {
            // 🔹 RUTE LAPORAN UTAMA
            Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
            Route::get('/laporan/detail/{dosen}', [LaporanController::class, 'detail'])->name('laporan.detail');
            Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');
            Route::get('/laporan/cetak-detail/{dosen}', [LaporanController::class, 'cetakDetail'])->name('laporan.cetakDetail');

            // 🔸 RUTE BARU: DOSEN INAKTIF
            Route::get('/laporan/inaktif', [LaporanController::class, 'inaktif'])->name('laporan.inaktif');
            Route::get('/laporan/cetak-inaktif', [LaporanController::class, 'cetakInaktif'])->name('laporan.cetakInaktif');

            // 🔹 RUTE KELOLA ADMIN (CRUD)
            Route::resource('admins', AdminController::class)->except(['show']);

            // 🔹 RUTE TRASH TERPUSAT
            Route::prefix('trash')->name('trash.')->group(function () {
                Route::get('/', [TrashController::class, 'index'])->name('index');
                Route::post('/restore/{type}/{id}', [TrashController::class, 'restore'])->name('restore');
                Route::delete('/force-delete/{type}/{id}', [TrashController::class, 'forceDelete'])->name('forceDelete');
            });

            // 🔹 RUTE PROGRAM STUDI
            Route::resource('program-studi', ProgramStudiController::class)->except(['show', 'create']);

            // 🔹 RUTE JENIS PKM
            Route::resource('jenis-pkm', JenisPkmController::class)->except(['show', 'create']);
        });

        /*
        |--------------------------------------------------------------------------
        | RUTE UNTUK SEMUA ADMIN
        |--------------------------------------------------------------------------
        */
        Route::resource('dosen', AdminDosenController::class);
    });
});
