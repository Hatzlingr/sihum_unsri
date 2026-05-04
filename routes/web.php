<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

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
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
});

Route::post('logout', [LoginController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| Role-Based Dashboard Routes (Proteksi Middleware)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Middleware 'admin' yang sudah kamu buat tadi
    Route::middleware(['admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');
    });

    // Middleware 'pengelola'
    Route::middleware(['pengelola'])->prefix('pengelola')->group(function () {
        Route::get('/dashboard', fn() => view('pengelola.dashboard'))->name('pengelola.dashboard');
    });

    // Middleware 'mahasiswa'
    Route::middleware(['mahasiswa'])->prefix('mahasiswa')->group(function () {
        Route::get('/dashboard', fn() => view('mahasiswa.dashboard'))->name('mahasiswa.dashboard');
    });

});