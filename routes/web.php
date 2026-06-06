<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// OAuth Socialite
Route::get('/auth/{provider}/redirect', [App\Http\Controllers\Auth\SocialiteController::class, 'redirect'])
    ->name('socialite.redirect');

Route::get('/auth/{provider}/callback', [App\Http\Controllers\Auth\SocialiteController::class, 'callback'])
    ->name('socialite.callback');
