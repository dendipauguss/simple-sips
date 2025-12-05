<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\SanksiController;
use App\Http\Controllers\PerintahSanksiController;
use App\Http\Controllers\PenindakanController;


Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route yang hanya boleh diakses jika sudah login
Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Route::get('/pengaturan/perintah-sanksi', [PerintahSanksiController::class, 'index'])->name('perintah-sanksi');
    Route::get('/penindakan/laporan', [PenindakanController::class, 'laporan']);
    Route::get('/penindakan/export-excel', [PenindakanController::class, 'exportExcel'])->name('penindakan.export.excel');
    Route::get('/penindakan/export-pdf',   [PenindakanController::class, 'exportPdf'])->name('penindakan.export.pdf');
    Route::put('/penindakan/perintah/status/{id}', [PenindakanController::class, 'updatePerintahStatus']);
    // Route::put('penindakan/update-status/{id}', [PenindakanController::class, 'updateStatus'])->name('penindakan.updateStatus');
    Route::get('/penindakan/status-updated', function () {
        return redirect()->back()->with('success', 'Status perintah berhasil diperbarui!');
    });
    Route::post('penindakan/upload-file', [PenindakanController::class, 'uploadDokumen']);
    // Route::get('/pengaturan/perintah-sanksi/{id}', [PerintahSanksiController::class, 'show']);
    Route::get('/perusahaan/import', [PerusahaanController::class, 'importView']);
    Route::post('/perusahaan/import', [PerusahaanController::class, 'import'])->name('perusahaan.import');
    Route::get('/get-perusahaan/{jenis_id}', [PerusahaanController::class, 'getPerusahaanByJenis']);
    Route::resource('/perusahaan', PerusahaanController::class);
    Route::resource('/pengaturan/sanksi', SanksiController::class);
    Route::resource('/pengaturan/perintah-sanksi', PerintahSanksiController::class);
    Route::resource('/penindakan', PenindakanController::class);
});
