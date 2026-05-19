<?php

declare(strict_types=1);

use App\Http\Controllers\CharacterController;
use App\Http\Controllers\VisitEventController;
use Illuminate\Support\Facades\Route;

Route::get('/characters', [CharacterController::class, 'index'])
    ->middleware('throttle:characters')
    ->name('characters');

Route::post('/visits', [VisitEventController::class, 'store'])
    ->middleware('throttle:visits')
    ->name('visits.store');
