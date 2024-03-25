<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\GameController::class, 'index'])
    ->name('index');

Route::get('/start-game-page',  function () {
    return view('start-game-page');
})->name('start-game-page');

Route::get('/game', [\App\Http\Controllers\GameController::class, 'index']
)->name('get-two-cards-game-page');


