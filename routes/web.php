<?php

use Illuminate\Support\Facades\Route;

// Home / Landing Page
Route::get('/', function () {
    return view('pages.home');
})->name('home');

// Authentication Pages
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function () {
    // Handle login
})->name('login.process');

Route::get('/daftar', function () {
    return view('auth.daftar');
})->name('daftar');

Route::post('/daftar', function () {
    // Handle registration
})->name('daftar.process');

// Hunian (Housing) Pages
Route::get('/hunian', function () {
    return view('hunian.index');
})->name('hunian.index');

Route::get('/hunian/{id}', function ($id) {
    return view('hunian.show');
})->name('hunian.show');

// Information Pages
Route::get('/panduan', function () {
    return view('pages.panduan');
})->name('panduan');

Route::get('/faq', function () {
    return view('pages.faq');
})->name('faq');

Route::get('/kontak', function () {
    return view('pages.kontak');
})->name('kontak');

Route::post('/kontak', function () {
    // Handle contact form
})->name('kontak.process');
