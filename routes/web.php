<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Mahasiswa\DashboardController as MahasiswaDashboard;
use App\Http\Controllers\Mahasiswa\HunianController as MahasiswaHunian;
use App\Http\Controllers\Mahasiswa\BiodataController as MahasiswaBiodata;
use App\Http\Controllers\Mahasiswa\PengaturanController as MahasiswaPengaturan;
use App\Http\Controllers\Mahasiswa\PengajuanController as MahasiswaPengajuan;
use App\Http\Controllers\Mahasiswa\PembayaranController as  MahasiswaPembayaran;

/*
|--------------------------------------------------------------------------
| Public Routes (Akses Tanpa Login)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('public.home');
})->name('home');

// Grup Hunian (Showcase)
Route::prefix('hunian')->name('hunian.')->group(function () {
    Route::get('/', function () {
        return view('public.hunian.index');
    })->name('index');

    // Sesuai permintaanmu: Showcase tanpa ID
    Route::get('/detail', function () {
        return view('public.hunian.show');
    })->name('show');
});

// Grup Informasi (Gunakan Route::view untuk efisiensi)
Route::view('/panduan', 'public.panduan')->name('panduan');
Route::view('/faq', 'public.faq')->name('faq');
Route::view('/kontak', 'public.kontak')->name('kontak');
Route::post('/kontak', function () {
    // Handle contact form logic
})->name('kontak.process');


/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    // Login
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);

    // Register (Khusus Mahasiswa)
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);

    // Forgot Password (Halaman Bantuan WA)
    Route::get('forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');
});

// Logout harus lewat middleware auth
Route::post('logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


/*
|--------------------------------------------------------------------------
| Role-Based Dashboard Routes (Proteksi Middleware)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Middleware 'admin' yang sudah kamu buat tadi
    Route::middleware(['admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');
        Route::get('/mahasiswa', fn() => view('admin.mahasiswa.index'))->name('admin.mahasiswa.index');
        Route::get('/hunian', fn() => view('admin.hunian.index'))->name('admin.hunian.index');
        Route::get('/pembayaran', fn() => view('admin.pembayaran.index'))->name('admin.pembayaran.index');
    });

    // Middleware 'pengelola'
    Route::middleware(['pengelola'])->prefix('pengelola')->group(function () {
        Route::get('/dashboard', fn() => view('pengelola.dashboard'))->name('pengelola.dashboard');
    });

    // Middleware 'mahasiswa'
    Route::middleware(['mahasiswa'])->prefix('mahasiswa')->group(function () {
        Route::get('/dashboard', [MahasiswaDashboard::class, 'index'])->name('mahasiswa.dashboard');
        Route::get('/hunian', [MahasiswaHunian::class, 'index'])->name('mahasiswa.hunian');
        Route::get('/pengajuan', [MahasiswaPengajuan::class, 'index'])->name('mahasiswa.pengajuan');
        Route::post('/pengajuan', [MahasiswaPengajuan::class, 'store'])->name('mahasiswa.pengajuan.store');
        Route::get('/pembayaran', [MahasiswaPembayaran::class, 'index'])->name('mahasiswa.pembayaran');
        Route::get('/pindah-kamar', fn() => view('mahasiswa.pindah-kamar'))->name('mahasiswa.pindah-kamar');
        Route::get('/pemberhentian', fn() => view('mahasiswa.pemberhentian'))->name('mahasiswa.pemberhentian');
        Route::get('/biodata', [MahasiswaBiodata::class, 'index'])->name('mahasiswa.biodata');
        Route::put('/biodata', [MahasiswaBiodata::class, 'update'])->name('mahasiswa.biodata.update');
        Route::get('/pengaturan', [MahasiswaPengaturan::class, 'index'])->name('mahasiswa.pengaturan');
        Route::put('/pengaturan/password', [MahasiswaPengaturan::class, 'updatePassword'])->name('mahasiswa.pengaturan.update-password');
    });
});