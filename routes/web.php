<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\StatisticsController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::redirect('/dashboard', '/statistics-preview')->name('dashboard');

Route::view('/statistics-preview', 'statistics', [
    'hourlyLabels' => [],
    'hourlyValues' => [],
    'cityLabels' => [],
    'cityValues' => [],
    'totalVisits' => 0,
])->name('statistics');

Route::view('/login', 'auth.login')->name('login');

Route::post('/login', [LoginController::class, 'store'])
    ->middleware('throttle:login')
    ->name('login.perform');

Route::post('/logout', [LogoutController::class, 'store'])
    ->name('logout.perform');

Route::get('/statistics', [StatisticsController::class, 'index'])
    ->middleware('auth')
    ->name('statistics.index');

Route::view('testlist', 'testlist')->name('testlist');
