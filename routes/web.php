<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SanksiController;
use App\Http\Controllers\PerintahSanksiController;
use App\Http\Controllers\PelakuUsahaController;
use App\Http\Controllers\JenisPelakuUsahaController;
use App\Http\Controllers\PengenaanSanksiController;
use App\Http\Controllers\PengenaanSPController;
use App\Http\Controllers\JenisPelanggaranController;
use App\Http\Controllers\KategoriSPController;

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
    Route::get('/penindakan/laporan', [PengenaanSanksiController::class, 'laporan']);
    Route::get('/penindakan/export-excel', [PengenaanSanksiController::class, 'exportExcel'])->name('penindakan.export.excel');
    Route::get('/penindakan/export-pdf',   [PengenaanSanksiController::class, 'exportPdf'])->name('penindakan.export.pdf');
    Route::put('/penindakan/perintah/status/{id}', [PengenaanSanksiController::class, 'updatePerintahStatus']);
    // Route::put('penindakan/update-status/{id}', [PengenaanSanksiController::class, 'updateStatus'])->name('penindakan.updateStatus');
    Route::get('/penindakan/status-updated', function () {
        return redirect()->back()->with('success', 'Status perintah berhasil diperbarui!');
    });
    Route::post('penindakan/upload-file', [PengenaanSanksiController::class, 'uploadDokumen']);
    // Route::get('/pengaturan/perintah-sanksi/{id}', [PerintahSanksiController::class, 'show']);
    Route::get('/pengaturan/pelaku-usaha/import', [PelakuUsahaController::class, 'importView']);
    Route::post('/pengaturan/pelaku-usaha/import', [PelakuUsahaController::class, 'import'])->name('pelaku-usaha.import');
    Route::get('/get-pelaku-usaha/{jenis_id}', [PelakuUsahaController::class, 'getPelakuUsahaByJenis']);
    Route::get('/get-kategori-sp/{jenis_pelanggaran_id}', [JenisPelanggaranController::class, 'getKategoriSPByJenis']);
    Route::get('/pengenaan-sp/export-excel', [PengenaanSPController::class, 'exportExcel'])->name('pengenaan-sp.export.excel');
    Route::get('/pengenaan-sp/export-pdf',   [PengenaanSPController::class, 'exportPdf'])->name('pengenaan-sp.export.pdf');
    Route::get('/pengenaan-sp/{id}/generate-pdf', [PengenaanSPController::class, 'generatePdf'])
        ->name('pengenaan-sp.generate-pdf');
    Route::get('/pengenaan-sp/{id}/tindak-lanjut', [PengenaanSPController::class, 'tindakLanjut'])
        ->name('pengenaan-sp.tindak-lanjut');
    Route::post('/pengenaan-sp/upload-dokumen', [PengenaanSPController::class, 'uploadDokumen'])->name('pengenaan-sp.upload-dokumen');
    Route::get('/pengenaan-sp/laporan', [PengenaanSPController::class, 'laporan'])->name('pengenaan-sp.laporan');
    Route::resource('/pengaturan/pelaku-usaha', PelakuUsahaController::class)->middleware('admin');
    Route::resource('/pengaturan/jenis-pelaku-usaha', JenisPelakuUsahaController::class)->middleware('admin');
    Route::resource('/pengaturan/sanksi', SanksiController::class)->middleware('admin');
    Route::resource('/pengaturan/perintah-sanksi', PerintahSanksiController::class)->middleware('admin');
    Route::resource('/pengaturan/users', UserController::class)->middleware('admin');
    Route::resource('/pengaturan/jenis-pelanggaran', JenisPelanggaranController::class)->middleware('admin');
    Route::resource('/pengaturan/kategori-sp', KategoriSPController::class)->middleware('admin');
    Route::resource('/penindakan', PengenaanSanksiController::class);
    Route::resource('/pengenaan-sp', PengenaanSPController::class);
});
