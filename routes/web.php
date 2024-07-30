<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;


Route::get('', [DashboardController::class, 'home']);
Route::get('/produk', [DashboardController::class, 'produk']);
Route::get('/produk/{produk:slug}', [DashboardController::class, 'show']);
Route::get('/tentang-kami', [DashboardController::class, 'tentang']);
Route::get('/hubungi-kami', [DashboardController::class, 'hubungi']);

Route::middleware('guest')->group(function(){
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'Autentikasi']);
    Route::get('/register', [AuthController::class, 'register']);
    Route::post('/register', [AuthController::class, 'RegisterStore']);
    Route::get('/register/otp', [AuthController::class, 'otpView']);
    Route::post('/register/otp', [AuthController::class, 'cekOtp']);
    Route::get('/kirim-otp/{verificationcode}', [AuthController::class, 'kirim_ulang_otp'])->where('verificationcode', '[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}');
    Route::get('/lupa-password', [AuthController::class, 'lupaPassword']);
    Route::post('/lupa-password', [ResetPasswordController::class, 'sendResetToken']);
    Route::get('/reset-password', [ResetPasswordController::class, 'resetPassword']);
    Route::post('/reset-password', [ResetPasswordController::class, 'updatePassword']);
});

Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/keranjang/{username}', [UserController::class, 'keranjangList']);
    Route::get('/profil/{username}', [UserController::class, 'Profil']);
    Route::post('/tambah-ke-keranjang', [UserController::class, 'tambahKeKeranjang']);
    Route::post('/hapus-keranjang', [UserController::class, 'hapusKeranjang']);
    Route::get('/checkout/{username}', [UserController::class, 'Checkout']);
    Route::post('/checkout/{username}', [UserController::class, 'ProsesCheckout']);
    Route::post('/fetch-shipping-methods', [UserController::class, 'fetchShippingMethods']);
    Route::post('/update-profile', [UserController::class, 'updateProfile']);
    Route::get('/riwayat-pesanan/{username}', [UserController::class, 'riwayatPesanan']);
    Route::get('/detail-pesanan/{username}/{invoice}', [UserController::class, 'detailPesanan']);
    Route::post('/batalkan-pesanan', [UserController::class, 'batalPesan']);
    Route::post('/terima-pesanan', [UserController::class, 'terimaPesanan']);
    Route::get('/proses-pembayaran/{invoice}', [UserController::class, 'pembayaran']);
    Route::get('/pembayaran-berhasil/{username}/{invoice}', [UserController::class, 'bayarBerhasil']);
});
Route::middleware(['auth', 'admin'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard']);
        Route::get('/produk-kategori', [AdminController::class, 'kategori']);
        Route::get('/tambah-kategori', [AdminController::class, 'tambahKategori']);
        Route::post('/tambah-kategori', [AdminController::class, 'simpanKategoriBaru']);
        Route::post('/hapus-kategori/{slug}', [AdminController::class, 'hapusKategori']);
        Route::get('/edit-kategori/{slug}', [AdminController::class, 'editKategori']);
        Route::post('/edit-kategori/{slug}', [AdminController::class, 'updateKategoriBaru']);
        Route::get('/produk', [AdminController::class, 'produk']);
        Route::get('/tambah-produk', [AdminController::class, 'tambahProduk']);
        Route::post('/tambah-produk', [AdminController::class, 'simpanProduk']);
        Route::post('/hapus-produk/{slug}', [AdminController::class, 'hapusProduk']);
        Route::get('/edit-produk/{slug}', [AdminController::class, 'editProduk']);
        Route::post('/edit-produk', [AdminController::class, 'updateProduk']);
        Route::get('/pesanan', [AdminController::class, 'pesanan']);
        Route::get('/detail-pesanan/{invoice}', [AdminController::class, 'detailPesanan']);
        Route::post('/batalkan-pesanan/{invoice}', [AdminController::class, 'batalkanPesanan']);
        Route::post('/selesaikan-pesanan/{invoice}', [AdminController::class, 'selesaikanPesanan']);
        Route::post('/tambah-nomor-resi/{invoice}', [AdminController::class, 'tambahNoResi']);
        Route::get('/profil', [AdminController::class, 'profilAdmin']);
        Route::post('/profil', [AdminController::class, 'profilAdminUpdate']);
    });
});

Route::middleware('auth')->group(function () {
    Route::post('/logout',[AuthController::class,'logout']);
});