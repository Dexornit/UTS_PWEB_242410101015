<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

// Root redirect ke login
Route::get('/', function () {
    return redirect('/login');
});

// Login
Route::get('/login', [PageController::class, 'login'])->name('login');
Route::post('/login/proses', [PageController::class, 'prosesLogin'])->name('login.proses');

// Halaman utama (butuh session)
Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');
Route::get('/pengelolaan', [PageController::class, 'pengelolaan'])->name('pengelolaan');
Route::get('/profile', [PageController::class, 'profile'])->name('profile');

// Logout
Route::post('/logout', [PageController::class, 'logout'])->name('logout');
