<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

// ─────────────────────────────────────────
// Public Pages
// ─────────────────────────────────────────

Route::get('/', function () {
    if (auth()->check()) {
        return match (auth()->user()->role) {
            'Admin'     => redirect()->route('admin.dashboard'),
            'Pengelola' => redirect()->route('pengelola.dashboard'),
            'Mahasiswa' => redirect()->route('mahasiswa.dashboard'),
            default     => view('public.home'),
        };
    }
    return view('public.home');
})->name('home');

Route::get('/hunian', function () {
    return view('public.hunian.index');
})->name('hunian.index');

Route::get('/hunian/{id}', function ($id) {
    return view('public.hunian.show');
})->name('hunian.show');

Route::get('/panduan', function () {
    return view('public.panduan');
})->name('panduan');

Route::get('/faq', function () {
    return view('public.faq');
})->name('faq');

Route::get('/kontak', function () {
    return view('public.kontak');
})->name('kontak');

Route::post('/kontak', function () {
    // Handle contact form
})->name('kontak.process');

// ─────────────────────────────────────────
// Auth Routes (Guest only)
// ─────────────────────────────────────────

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ─────────────────────────────────────────
// Authenticated Routes (placeholder)
// ─────────────────────────────────────────

Route::middleware('auth')->group(function () {
    // Admin
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Pengelola
    Route::get('/pengelola/dashboard', function () {
        return view('pengelola.dashboard');
    })->name('pengelola.dashboard');

    // Mahasiswa
    Route::get('/mahasiswa/dashboard', function () {
        return view('pengelola.dashboard');
    })->name('mahasiswa.dashboard');
});

?>