<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'login'])
    ->name('login')
    ->middleware('guest');

Route::get('/register', [AuthController::class, 'register'])
    ->name('register')
    ->middleware('guest');

Route::post('/register', [AuthController::class, 'registerUser'])
    ->name('register.user')
    ->middleware('guest');

Route::post('/login', [AuthController::class, 'loginUser'])
    ->name('login.user')
    ->middleware('guest');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

Route::get('/profile', [AuthController::class, 'profile'])
    ->name('profile')
    ->middleware('auth');

Route::post('/profile', [AuthController::class, 'updateProfile'])
    ->name('profile.update')
    ->middleware('auth');
