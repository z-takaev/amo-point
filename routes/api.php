<?php

declare(strict_types=1);

use App\Http\Controllers\CharacterController;
use Illuminate\Support\Facades\Route;

Route::get('/characters', [CharacterController::class, 'index'])
    ->middleware('throttle:characters')
    ->name('characters.index');
