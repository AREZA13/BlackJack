<?php

use App\Http\Controllers\BlackJackController;
use App\Http\Controllers\PokerController;
use Illuminate\Support\Facades\Route;


Route::prefix('blackjack')->group(function () {
    Route::get('/', [BlackJackController::class, 'start'])
        ->name('blackjack-index');
    Route::get('start-game-page', [BlackJackController::class, 'home'])
        ->name('blackjack-start-game-page');
    Route::get('game', [BlackJackController::class, 'start'])
        ->name('blackjack-get-two-cards-game-page');
    Route::get('more-card', [BlackJackController::class, 'oneMoreCardPage'],)
        ->name('blackjack-one-more-card-page');
    Route::get('stop-game', [BlackJackController::class, 'generateRandomDealerScore'])
        ->name('blackjack-stop-game-page');
    Route::get('/game-delete', [BlackJackController::class, 'removeSession'])
        ->name('blackjack-game-delete');
});

Route::get('/', [BlackJackController::class, 'chooseGame'])
    ->name('choose-game');
Route::get('poker', [PokerController::class, 'get'])
    ->name('pokerGet');
Route::post('poker', [PokerController::class, 'post'])
    ->name('pokerPost');
Route::post('all-in-bet', 'App\Http\Controllers\PokerController@allInBet')
    ->name('allInBet');
Route::get('poker-game-delete', [PokerController::class, 'removeSession'])
    ->name('poker-game-delete');


