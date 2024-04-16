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

Route::prefix('poker')->group(function () {

    Route::get('start-game-page', [\App\Http\Controllers\PokerController::class, 'home'])
        ->name('poker-start-game-page');
    Route::get('preFlop', [\App\Http\Controllers\PokerController::class, 'preFlop'])
        ->name('preFlop');
    Route::post('preFlop-bet', [\App\Http\Controllers\PokerController::class, 'preFlopBet'])
        ->name('preFlopBet');
    Route::get('flop', [\App\Http\Controllers\PokerController::class, 'flop'])
        ->name('flop');
    Route::post('flop-bet', [\App\Http\Controllers\PokerController::class, 'flopBet'])
        ->name('flopBet');
    Route::post('turn-bet', [\App\Http\Controllers\PokerController::class, 'turnBet'])
        ->name('turnBet');
    Route::post('river-bet', [\App\Http\Controllers\PokerController::class, 'riverBet'])
        ->name('riverBet');
    Route::get('turn', [\App\Http\Controllers\PokerController::class, 'turn'])
        ->name('turn');
    Route::get('river', [\App\Http\Controllers\PokerController::class, 'river'])
        ->name('river');
    Route::post('all-in-bet', [\App\Http\Controllers\PokerController::class, 'allInBet'])
        ->name('allInBet');

    Route::get('/game-delete', [\App\Http\Controllers\PokerController::class, 'removeSession'])
        ->name('poker-game-delete');


});
