<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

// Home / Landing Page
Route::get('/', function () {
    return view('public.home');
})->name('home');


// Hunian (Housing) Pages
Route::get('/hunian', function () {
    return view('public.hunian.index');
})->name('hunian.index');

Route::get('/hunian/{id}', function ($id) {
    return view('public.hunian.show');
})->name('hunian.show');

// Information Pages
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

// Authentication Routes
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

    // Register
    Route::get('/register', [RegisteredUserController::class, 'create'])
        ->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

// Logout (untuk authenticated users)
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// Dashboard Routes (Protected)
Route::middleware('auth')->group(function () {
    
    // Admin Dashboard
    Route::prefix('admin')->name('admin.')->middleware('role:Admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::get('/hunian', function () {
            return view('admin.hunian.index');
        })->name('hunian.index');

        Route::get('/kamar', function () {
            return view('admin.kamar.index');
        })->name('kamar.index');

        Route::get('/mahasiswa', function () {
            return view('admin.mahasiswa.index');
        })->name('mahasiswa.index');

        Route::get('/pengelola', function () {
            return view('admin.pengelola.index');
        })->name('pengelola.index');

        Route::get('/pendaftaran', function () {
            return view('admin.pendaftaran.index');
        })->name('pendaftaran.index');

        Route::get('/penempatan', function () {
            return view('admin.penempatan.index');
        })->name('penempatan.index');

        Route::get('/pembayaran', function () {
            return view('admin.pembayaran.index');
        })->name('pembayaran.index');

        Route::get('/perpanjangan', function () {
            return view('admin.perpanjangan.index');
        })->name('perpanjangan.index');

        Route::get('/pindah-kamar', function () {
            return view('admin.pindah-kamar.index');
        })->name('pindah-kamar.index');

        Route::get('/dokumen-pendaftaran', function () {
            return view('admin.dokumen-pendaftaran.index');
        })->name('dokumen-pendaftaran.index');

        Route::get('/activity-log', function () {
            return view('admin.activity-log.index');
        })->name('activity-log.index');
    });

    // Mahasiswa Dashboard
    Route::prefix('mahasiswa')->name('mahasiswa.')->middleware('role:Mahasiswa')->group(function () {
        Route::get('/dashboard', function () {
            return view('mahasiswa.dashboard');
        })->name('dashboard');

        // TODO: Tambahkan route mahasiswa lainnya
    });

    // Pengelola Dashboard
    Route::prefix('pengelola')->name('pengelola.')->middleware('role:Pengelola')->group(function () {
        Route::get('/dashboard', function () {
            return view('pemilik-kos.dashboard');
        })->name('dashboard');

        // TODO: Tambahkan route pengelola lainnya
    });
});