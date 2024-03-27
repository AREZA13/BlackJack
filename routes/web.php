<?php

use Illuminate\Support\Facades\Route;

Route::prefix('blackjack')->group(function () {

    Route::get('/', [\App\Http\Controllers\GameController::class, 'start'])
        ->name('blackjack-index');

    Route::get('start-game-page', [\App\Http\Controllers\GameController::class, 'home'])
        ->name('blackjack-start-game-page');

    Route::get('game', [\App\Http\Controllers\GameController::class, 'start'])
        ->name('blackjack-get-two-cards-game-page');

    Route::get('more-card', [\App\Http\Controllers\GameController::class, 'oneMoreCardPage'],)
        ->name('blackjack-one-more-card-page');

    Route::get('stop-game', [\App\Http\Controllers\GameController::class, 'generateRandomDealerScore'])
        ->name('blackjack-stop-game-page');

    Route::get('/game-delete', [\App\Http\Controllers\GameController::class, 'removeSession'])
        ->name('blackjack-game-delete');
});
