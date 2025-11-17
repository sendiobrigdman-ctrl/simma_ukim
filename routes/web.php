<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MitraDashboardController;
use App\Http\Controllers\MitraLowonganController;
use App\Http\Controllers\MitraAplikasiController;
use App\Http\Middleware\EnsureRoleIsMitra;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\DosenLogbookController;
use App\Http\Middleware\EnsureRoleIsDosen;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', EnsureRoleIsMitra::class])->prefix('mitra')->name('mitra.')->group(function () {
    Route::get('/', [MitraDashboardController::class, 'index'])->name('dashboard');
    Route::resource('lowongans', MitraLowonganController::class);
    Route::patch('/aplikasi/{aplikasi}/status', [MitraAplikasiController::class, 'updateStatus'])->name('aplikasi.updateStatus');
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
});

