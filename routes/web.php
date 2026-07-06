<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PuskesmasController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PemeriksaanController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware('role:admin_dinkes')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('puskesmas', PuskesmasController::class);
        Route::resource('master-obat', \App\Http\Controllers\MasterObatController::class)->except(['create', 'show', 'edit']);
    });

    Route::get('/pasien/{pasien}/print', [PasienController::class, 'printPdf'])->name('pasien.print');
    Route::resource('pasien', PasienController::class);
    
    Route::get('/pemeriksaan/{pemeriksaan}/print', [PemeriksaanController::class, 'printPdf'])->name('pemeriksaan.print');
    Route::resource('pemeriksaan', PemeriksaanController::class);

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::post('/laporan/export-csv', [LaporanController::class, 'exportCsv'])->name('laporan.export.csv');
    Route::post('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export.pdf');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
