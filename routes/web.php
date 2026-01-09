<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SanksiController;
use App\Http\Controllers\PerintahSanksiController;
use App\Http\Controllers\PelakuUsahaController;
use App\Http\Controllers\JenisPelakuUsahaController;
use App\Http\Controllers\PengenaanSPController;
use App\Http\Controllers\JenisPelanggaranController;
use App\Http\Controllers\KategoriSPController;
use App\Http\Controllers\SKController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\NotaDinasController;
use App\Http\Controllers\DasarPengenaanSanksiController;
use App\Http\Controllers\OneDriveController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// AUTH ROUTES
// Route yang hanya boleh diakses jika sudah login
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/chart', [DashboardController::class, 'chartData']);
    // Route::get('/pengaturan/perintah-sanksi', [PerintahSanksiController::class, 'index'])->name('perintah-sanksi');    
    // Route::get('/pengaturan/perintah-sanksi/{id}', [PerintahSanksiController::class, 'show']);
    Route::get('/pengaturan/pelaku-usaha/import', [PelakuUsahaController::class, 'importView']);
    Route::post('/pengaturan/pelaku-usaha/import', [PelakuUsahaController::class, 'import'])->name('pelaku-usaha.import');
    Route::get('/get-pelaku-usaha/{jenis_id}', [PelakuUsahaController::class, 'getPelakuUsahaByJenis']);
    Route::get('/get-kategori-sp/{jenis_pelanggaran_id}', [JenisPelanggaranController::class, 'getKategoriSPByJenis']);
    Route::get('/get-jenis-pelanggaran/{dasar_pengenaan_sanksi_id}', [DasarPengenaanSanksiController::class, 'getJenisPelanggaranByDasarPengenaanSanksi']);
    Route::get('/pengenaan-sp/export-excel', [PengenaanSPController::class, 'exportExcel'])->name('pengenaan-sp.export.excel');
    Route::get('/pengenaan-sp/export-pdf',   [PengenaanSPController::class, 'exportPdf'])->name('pengenaan-sp.export.pdf');
    Route::get('/pengenaan-sp/generate-laporan',   [PengenaanSPController::class, 'generateLaporan'])->name('pengenaan-sp.generate.laporan');
    Route::get('/pengenaan-sp/{id}/generate-pdf', [PengenaanSPController::class, 'generatePdf'])
        ->name('pengenaan-sp.generate-pdf');
    Route::post('/pengenaan-sp/upload-dokumen', [PengenaanSPController::class, 'uploadDokumenTanggapan'])->name('pengenaan-sp.upload-dokumen');
    Route::get('/pengenaan-sp/laporan', [PengenaanSPController::class, 'laporan'])->name('pengenaan-sp.laporan');
    Route::get('/pengenaan-sp/import', [PengenaanSPController::class, 'importView']);
    Route::post('/pengenaan-sp/import', [PengenaanSPController::class, 'import'])->name('pengenaan-sp.import');
    Route::get('/pengaturan/kategori-sp/import', [KategoriSPController::class, 'importView']);
    Route::post('/pengaturan/kategori-sp/import', [KategoriSPController::class, 'import'])->name('kategori-sp.import');
    Route::get('/sk/create/{id}', [SKController::class, 'create'])->name('sk.create');
    Route::delete('/dokumen/hapus/{id}', [PengenaanSPController::class, 'hapusDokumen'])->name('dokumen.hapus');
    // Laporan
    Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('laporan/generate', [LaporanController::class, 'generate'])->name('laporan.generate');
    Route::put('laporan/isi-catatan/{id}', [LaporanController::class, 'isiCatatan'])->name('laporan.isi-catatan');
    Route::get('laporan/{id}', [LaporanController::class, 'show'])->name('laporan.show');
    Route::get('laporan/{id}/pdf', [LaporanController::class, 'pdf'])->name('laporan.pdf');
    // Route::post('laporan/{id}/approve', [LaporanController::class, 'approve'])->name('laporan.approve');
    Route::post('laporan/approve', [LaporanController::class, 'approve'])
        ->name('laporan.approve');
    Route::get('/auth/microsoft', [OneDriveController::class, 'redirect']);
    Route::get('/auth/microsoft/callback', [OneDriveController::class, 'callback']);
    Route::get('/onedrive/upload', [OneDriveController::class, 'index']);
    Route::post('/onedrive/upload', [OneDriveController::class, 'upload'])->name('store-file');
    Route::resource('/pengaturan/pelaku-usaha', PelakuUsahaController::class)->middleware('admin');
    Route::resource('/pengaturan/jenis-pelaku-usaha', JenisPelakuUsahaController::class)->middleware('admin');
    Route::resource('/pengaturan/sanksi', SanksiController::class)->middleware('admin');
    Route::resource('/pengaturan/perintah-sanksi', PerintahSanksiController::class)->middleware('admin');
    Route::resource('/pengaturan/users', UserController::class)->middleware('admin');
    Route::resource('/pengaturan/jenis-pelanggaran', JenisPelanggaranController::class)->middleware('admin');
    Route::resource('/pengaturan/kategori-sp', KategoriSPController::class)->middleware('admin');
    Route::resource('/nota-dinas', NotaDinasController::class)->middleware('admin');
    Route::resource('/pengenaan-sp', PengenaanSPController::class);
    Route::resource('/sk', SKController::class);
});
// AUTH ROUTES

Route::get('/verify-approval/{hash}', [LaporanController::class, 'verify'])
    ->name('laporan.verify');
