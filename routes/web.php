<?php
// ========================================
// FILE: routes/web.php
// FUNGSI: Mendefinisikan semua URL route aplikasi
// ========================================

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;

// ================================================
// ROUTE PUBLIK (Bisa diakses siapa saja)
// ================================================
Route::get('/', function () {
    return view('welcome');
});
// ↑ Halaman utama, tidak perlu login

// ================================================
// AUTH ROUTES
// ================================================
// Auth::routes() adalah "shortcut" yang membuat banyak route sekaligus:
// - GET  /login           → Tampilkan form login
// - POST /login           → Proses login
// - POST /logout          → Proses logout
// - GET  /register        → Tampilkan form register
// - POST /register        → Proses register
// - GET  /password/reset  → Tampilkan form lupa password
// - POST /password/email  → Kirim email reset password
// - dll...
// ================================================
Auth::routes();

// ================================================
// ROUTE YANG MEMERLUKAN LOGIN
// ================================================
// middleware('auth') = Harus login dulu untuk akses
// Jika belum login, otomatis redirect ke /login
// ================================================
Route::middleware('auth')->group(function () {
    // Semua route di dalam group ini HARUS LOGIN

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
        ->name('home');
    // ↑ ->name('home') = Memberi nama route
    // Kegunaan: route('home') akan menghasilkan URL /home

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
});