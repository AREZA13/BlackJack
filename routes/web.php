<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\GameController::class, 'index'])
    ->name('index');
