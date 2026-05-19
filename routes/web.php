<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\StatisticsController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::view('/testlist', 'testlist')->name('testlist');
Route::redirect('/dashboard', '/statistics')->name('dashboard');

Route::get('/statistics', [StatisticsController::class, 'index'])
    ->middleware('auth')
    ->name('statistics');

Route::view('/login', 'auth.login')
    ->middleware('guest')
    ->name('login');

Route::post('/login', LoginController::class)
    ->middleware('throttle:login')
    ->name('login.perform');

Route::post('/logout', LogoutController::class)
    ->name('logout');
