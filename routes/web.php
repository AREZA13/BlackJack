<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\GameController::class, 'index'])
    ->name('index');

Route::get('/game', function () {
    return view('game-page');
})->name('show-game-page');
