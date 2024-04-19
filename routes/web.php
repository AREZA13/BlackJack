<?php

use Illuminate\Support\Facades\Route;

Route::prefix('blackjack')->group(function () {

    Route::get('/', [\App\Http\Controllers\BlackJackController::class, 'start'])
        ->name('blackjack-index');

    Route::get('start-game-page', [\App\Http\Controllers\BlackJackController::class, 'home'])
        ->name('blackjack-start-game-page');

    Route::get('game', [\App\Http\Controllers\BlackJackController::class, 'start'])
        ->name('blackjack-get-two-cards-game-page');

    Route::get('more-card', [\App\Http\Controllers\BlackJackController::class, 'oneMoreCardPage'],)
        ->name('blackjack-one-more-card-page');

    Route::get('stop-game', [\App\Http\Controllers\BlackJackController::class, 'generateRandomDealerScore'])
        ->name('blackjack-stop-game-page');

    Route::get('/game-delete', [\App\Http\Controllers\BlackJackController::class, 'removeSession'])
        ->name('blackjack-game-delete');
});

Route::get('/', [\App\Http\Controllers\BlackJackController::class, 'chooseGame'])
    ->name('choose-game');

Route::get('poker', [\App\Http\Controllers\PokerController::class, 'get'])
    ->name('pokerGet');
Route::post('poker', [\App\Http\Controllers\PokerController::class, 'post'])
    ->name('pokerPost');

Route::post('all-in-bet', [\App\Game\Poker\Poker::class, 'allInBet'])
    ->name('allInBet');
Route::get('poker-game-delete', [\App\Game\Poker\Poker::class, 'removeSession'])
    ->name('poker-game-delete');


