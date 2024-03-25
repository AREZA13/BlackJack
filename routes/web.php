<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\GameController::class, 'index'])
    ->name('index');

Route::get('/start-game-page', [\App\Http\Controllers\GameController::class, 'home']
)->name('start-game-page');

Route::get('/game', [\App\Http\Controllers\GameController::class, 'index']
)->name('get-two-cards-game-page');

Route::get('/gameDelete', [\App\Http\Controllers\GameController::class, 'removeSession']
)->name('game-delete');

