<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GoogleController;

// ================================================
// ROUTE PUBLIK
// ================================================
Route::get('/', function () {
    return view('welcome');
});

// ================================================
// AUTH ROUTES (LOGIN, REGISTER, DLL)
// ================================================
Auth::routes();

// ================================================
// GOOGLE LOGIN (HARUS PUBLIK)
// ================================================
Route::controller(GoogleController::class)->group(function () {

    Route::get('/auth/google', 'redirect')
        ->name('auth.google');

    Route::get('/auth/google/callback', 'callback')
        ->name('auth.google.callback');
});

// ================================================
// ROUTE YANG MEMERLUKAN LOGIN
// ================================================
Route::middleware('auth')->group(function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
        ->name('home');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
});