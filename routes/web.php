<?php

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

Route::get('/', function () {
    return view('welcome');
});
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\PenyewaController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\LaporanController;


// Redirect default ke login
Route::get('/', function () {
    return redirect('/login');
});

// // Autentikasi
// Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
// Route::post('/login', [AuthController::class, 'login']);
// Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Group route setelah login (admin-only)
Route::prefix('admin')->as('admin.')->middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Manajemen Kamar
    Route::resource('kamar', KamarController::class);

    // Manajemen Penyewa
    Route::resource('penyewa', PenyewaController::class);
    Route::put('/admin/penyewa/{penyewa}', [PenyewaController::class, 'update'])->name('admin.penyewa.update');

    // Pembayaran
    Route::resource('pembayaran', PembayaranController::class);
    Route::get('/pembayaran/riwayat', [PembayaranController::class, 'riwayat'])->name('pembayaran.riwayat');
    Route::get('/admin/keuangan/pembayaran', [PembayaranController::class, 'riwayat'])->name('admin.pembayaran.riwayat');
    Route::get('/admin/pembayaran/edit', [PembayaranController::class, 'editCustom']);


    // Tagihan
    Route::get('/pembayaran/{id}/struk', [PembayaranController::class, 'cetak'])->name('pembayaran.struk');

    // Laporan
    Route::resource('laporan', LaporanController::class);

    // Export Transaksi (contoh tambahan)
    // Route::get('/pembayaran-export', [PembayaranController::class, 'export'])->name('pembayaran.export');
});

