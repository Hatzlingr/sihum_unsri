<?php

use Illuminate\Support\Facades\Route;

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

Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');

?>