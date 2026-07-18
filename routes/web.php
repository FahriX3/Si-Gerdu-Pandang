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
    Route::get('/dashboard/export', [DashboardController::class, 'exportPdf'])->name('dashboard.exportPdf');

    Route::middleware('role:admin_dinkes')->group(function () {
        Route::resource('users', UserController::class);
        Route::get('puskesmas/{puskesma}/kelurahans', [PuskesmasController::class, 'getKelurahans'])->name('puskesmas.kelurahans');
        Route::get('kelurahans', [PuskesmasController::class, 'getAllKelurahans'])->name('kelurahans.all');
        Route::resource('puskesmas', PuskesmasController::class);
        Route::resource('master-obat', \App\Http\Controllers\MasterObatController::class)->except(['create', 'show', 'edit']);
        Route::resource('master-pekerjaan', \App\Http\Controllers\MasterPekerjaanController::class)->except(['create', 'show', 'edit']);
        Route::resource('master-kelurahan', \App\Http\Controllers\MasterKelurahanController::class)->except(['create', 'show', 'edit']);
        Route::resource('master-dukuh', \App\Http\Controllers\MasterDukuhController::class)->except(['create', 'show', 'edit']);
        Route::resource('master-diagnosis', \App\Http\Controllers\MasterDiagnosisController::class)->except(['create', 'show', 'edit']);
        Route::resource('master-kelompok-gp', \App\Http\Controllers\MasterKelompokGpController::class)->except(['create', 'show', 'edit']);
    });

    Route::get('/pasien/{pasien}/print', [PasienController::class, 'printPdf'])->name('pasien.print');
    Route::post('/pasien/export-register', [\App\Http\Controllers\PasienController::class, 'exportRegisterPdf'])->name('pasien.exportRegisterPdf');
    Route::get('/pasien/dukuhs', [PasienController::class, 'getDukuhs'])->name('pasien.dukuhs');
    Route::resource('pasien', PasienController::class);
    
    Route::get('/pemeriksaan/{pemeriksaan}/print', [PemeriksaanController::class, 'printPdf'])->name('pemeriksaan.print');
    Route::resource('pemeriksaan', PemeriksaanController::class);

    Route::get('laporan', [\App\Http\Controllers\LaporanController::class, 'index'])->name('laporan.index');
    Route::get('laporan/register', [\App\Http\Controllers\LaporanController::class, 'register'])->name('laporan.register');
    Route::post('laporan/preview', [\App\Http\Controllers\LaporanController::class, 'preview'])->name('laporan.preview');
    Route::post('laporan/export/csv', [\App\Http\Controllers\LaporanController::class, 'exportCsv'])->name('laporan.export.csv');
    Route::post('laporan/export/pdf', [\App\Http\Controllers\LaporanController::class, 'exportPdf'])->name('laporan.export.pdf');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
