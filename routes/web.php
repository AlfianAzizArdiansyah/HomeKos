<?php

use App\Http\Controllers\AdminPengaduanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

require __DIR__ . '/auth.php';

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\PenghuniController;
use App\Http\Controllers\PenghuniKostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use App\Models\Pembayaran;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


// Redirect default ke login
Route::get('/', function () {
    return redirect('/login');
});

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');


// // Autentikasi
// Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
// Route::post('/login', [AuthController::class, 'login']);
// Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Group route setelah login (admin-only)
Route::prefix('admin')->as('admin.')->middleware(['auth', 'role:admin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Manajemen Kamar
    Route::resource('kamar', KamarController::class);

    // Manajemen Penghuni
    Route::resource('penghuni', PenghuniController::class);

    // Pembayaran
    Route::resource('pembayaran', PembayaranController::class)->except(['show']);
    Route::get('/pembayaran/riwayat', [PembayaranController::class, 'riwayat'])->name('pembayaran.riwayat');
    Route::get('/pembayaran/edit-custom', [PembayaranController::class, 'editCustom'])->name('pembayaran.editCustom');
    Route::get('/pembayaran/{pembayaran}/edit', [PembayaranController::class, 'edit'])->name('admin.pembayaran.edit');


    // Tagihan
    Route::get('/pembayaran/{id}/riwayatbayar', [PembayaranController::class, 'riwayatBayar'])->name('pembayaran.riwayatbayar');

    Route::get('/profil', [ProfileController::class, 'index'])->name('profil');

    // pengaduan
    Route::resource('pengaduan', AdminPengaduanController::class);




    // Laporan
    // Route::resource('laporan', LaporanController::class);

    // (Opsional) Export Transaksi
    // Route::get('/pembayaran-export', [PembayaranController::class, 'export'])->name('pembayaran.export');
});

// Untuk penghuni
Route::prefix('penghuni')->as('penghuni.')->middleware(['auth', 'role:penghuni'])->group(function () {
    Route::get('/dashboard', [PenghuniKostController::class, 'index'])->name('dashboard');
    Route::get('/riwayat-pembayaran', [PenghuniKostController::class, 'historyPay'])->name('riwayat-bayar');
    Route::post('/bukti-bayar/unggah/{id}', [PenghuniKostController::class, 'unggahBukti'])->name('bukti-bayar');
    Route::get('/profil', [ProfileController::class, 'index'])->name('profil');
    Route::get('/update-password', [ProfileController::class, 'updatePassword'])->name('update-password');
    Route::get('/transfer/{id}', [PembayaranController::class, 'showTransfer'])->name('transfer');
    Route::get('/pembayaran/cetak-pdf', [PembayaranController::class, 'cetakPDF'])->name('pembayaran.cetak-pdf');
    Route::get('/penghuni/invoice/{id}', [PembayaranController::class, 'cetakInvoice'])->name('invoice');
    Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
    Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');

});
