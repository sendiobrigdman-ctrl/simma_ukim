<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MitraDashboardController;
use App\Http\Controllers\MitraLowonganController;
use App\Http\Controllers\MitraAplikasiController;
use App\Http\Middleware\EnsureRoleIsMitra;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\DosenLogbookController;
use App\Http\Middleware\EnsureRoleIsDosen;
use App\Http\Middleware\EnsureRoleIsAdmin;
use App\Http\Controllers\AdminUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Download CV for aplikasi (auth required, further authorization inside controller)
    Route::get('/aplikasi/{aplikasi}/download-cv', [\App\Http\Controllers\AplikasiController::class, 'downloadCv'])
        ->name('aplikasi.downloadCv');
});

Route::middleware(['auth', EnsureRoleIsMitra::class])->prefix('mitra')->name('mitra.')->group(function () {
    Route::get('/', [MitraDashboardController::class, 'index'])->name('dashboard');
    Route::resource('lowongans', MitraLowonganController::class);
    Route::patch('/aplikasi/{aplikasi}/status', [MitraAplikasiController::class, 'updateStatus'])->name('aplikasi.updateStatus');
    
    Route::prefix('penilaian')->group(function () {
        Route::get('/', [\App\Http\Controllers\MitraPenilaianController::class, 'index'])->name('penilaian.index');
        Route::get('{aplikasi}/edit', [\App\Http\Controllers\MitraPenilaianController::class, 'edit'])->name('penilaian.edit');
        Route::post('{aplikasi}', [\App\Http\Controllers\MitraPenilaianController::class, 'update'])->name('penilaian.update');
        // Final evaluation (penilaian) by mitra
        Route::get('{aplikasi}/create', [\App\Http\Controllers\MitraPenilaianController::class, 'create'])->name('penilaian.create');
        Route::post('{aplikasi}/store', [\App\Http\Controllers\MitraPenilaianController::class, 'store'])->name('penilaian.store');
    });
    
    // Pelamar management for mitra: list applicants and update status
    Route::get('lowongan/{lowongan}/pelamar', [\App\Http\Controllers\MitraPelamarController::class, 'index'])->name('lowongans.pelamar.index');
    Route::patch('lamaran/{aplikasi}/status', [\App\Http\Controllers\MitraPelamarController::class, 'updateStatus'])->name('lamaran.updateStatus');
    
    // Logbook verification by mitra
    Route::get('logbooks', [\App\Http\Controllers\MitraLogbookController::class, 'index'])->name('logbooks.index');
    Route::patch('logbooks/{logbook}/status', [\App\Http\Controllers\MitraLogbookController::class, 'updateStatus'])->name('logbooks.updateStatus');
});

require __DIR__.'/auth.php';

Route::prefix('export')->group(function () {
    Route::get('/aplikasis', [ExportController::class, 'aplikasis'])->name('export.aplikasis');
    Route::get('/lowongans', [ExportController::class, 'lowongans'])->name('export.lowongans');
    Route::get('/logbook/{aplikasi}', [ExportController::class, 'logbook'])->name('export.logbook');
    Route::get('/logbooks-index/{aplikasi}', [ExportController::class, 'logbooksIndex'])->name('export.logbooks-index');
    Route::get('/nilai', [ExportController::class, 'nilai'])->name('export.nilai');
});

Route::prefix('dosen')->middleware(['auth', EnsureRoleIsDosen::class])->name('dosen.')->group(function () {
    Route::get('logbook', [DosenLogbookController::class, 'index'])->name('logbook.index');
    Route::get('logbook/{logbook}', [DosenLogbookController::class, 'show'])->name('logbook.show');
    Route::post('logbook/{logbook}/validate', [DosenLogbookController::class, 'update'])->name('logbook.update');
    
    Route::prefix('penilaian')->group(function () {
        Route::get('/', [\App\Http\Controllers\DosenPenilaianController::class, 'index'])->name('penilaian.index');
        Route::get('{aplikasi}/edit', [\App\Http\Controllers\DosenPenilaianController::class, 'edit'])->name('penilaian.edit');
        Route::post('{aplikasi}', [\App\Http\Controllers\DosenPenilaianController::class, 'update'])->name('penilaian.update');
    });
});

use App\Http\Controllers\MahasiswaLowonganController;
use App\Http\Controllers\MahasiswaAplikasiController;
use App\Http\Middleware\EnsureRoleIsMahasiswa;

// Mahasiswa portal lowongan & aplikasi
Route::middleware(['auth', EnsureRoleIsMahasiswa::class])->prefix('lowongan')->name('mahasiswa.lowongan.')->group(function () {
    Route::get('/', [MahasiswaLowonganController::class, 'index'])->name('index');
    Route::get('/{lowongan}', [MahasiswaLowonganController::class, 'show'])->name('show');
    Route::post('/{lowongan}/apply', [MahasiswaAplikasiController::class, 'store'])->name('apply');
});

// Mahasiswa application history
Route::middleware(['auth', EnsureRoleIsMahasiswa::class])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/lamaran', [MahasiswaAplikasiController::class, 'index'])->name('aplikasi.index');
    // Logbooks (buku harian kegiatan)
    Route::get('/logbooks', [\App\Http\Controllers\MahasiswaLogbookController::class, 'index'])->name('logbooks.index');
    Route::get('/logbooks/create', [\App\Http\Controllers\MahasiswaLogbookController::class, 'create'])->name('logbooks.create');
    Route::post('/logbooks', [\App\Http\Controllers\MahasiswaLogbookController::class, 'store'])->name('logbooks.store');
    Route::delete('/logbooks/{logbook}', [\App\Http\Controllers\MahasiswaLogbookController::class, 'destroy'])->name('logbooks.destroy');
    // Mahasiswa: view penilaian for their aplikasi
    Route::get('/penilaian/{aplikasi}', [\App\Http\Controllers\PenilaianController::class, 'show'])->name('penilaian.show');
    // Mahasiswa: view sertifikat if penilaian exists
    Route::get('/sertifikat/{penilaian}', [\App\Http\Controllers\SertifikatController::class, 'show'])->name('sertifikat.show');
});

Route::prefix('admin')->middleware(['auth', EnsureRoleIsAdmin::class])->name('admin.')->group(function () {
    Route::get('/', \App\Http\Controllers\AdminDashboardController::class)->name('dashboard');

    // User management
    Route::resource('users', AdminUserController::class);

    // Mitra management
    Route::resource('mitra', \App\Http\Controllers\AdminMitraController::class);

    // Lowongan moderation
    Route::get('lowongans/moderation', [\App\Http\Controllers\Admin\LowonganModerationController::class, 'index'])->name('lowongans.moderation.index');
    Route::get('lowongans/moderation/{lowongan}', [\App\Http\Controllers\Admin\LowonganModerationController::class, 'show'])->name('lowongans.moderation.show');
    Route::patch('lowongans/{lowongan}/status', [\App\Http\Controllers\Admin\LowonganModerationController::class, 'updateStatus'])->name('lowongans.moderation.updateStatus');
});

