@php
    use App\Game\Poker\Player;
 use App\Game\Poker\Poker;
@endphp
<?php
/** @var Player[] $players */
/** @var int $pot */
/** @var array $tableCards */
?>
@extends('poker/template')
@section('content')
    <style>
        body {
            background-image: url('../../images/front/bgForFinishGame.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: 100% 100%;
        }
    </style>

    <div style="text-align: center;">
        <button type="button" class="btn btn-primary btn-lg" disabled>Total Pot {{$pot}}</button>
    </div>
    <br>
    <div style="text-align: center;">
        @foreach($players as $player)
            <div>
                @foreach($player->getPocketCards() as $card)
                    <img src="{{ $card->getAsImagePath() }}" alt="{{ $card->getAsString() }}">
                @endforeach
            </div>
        @endforeach
        <br>
        @foreach($tableCards as $tableCard)

                <img src="{{ $tableCard->getAsImagePath() }}" alt="{{ $tableCard->getAsString() }}">
        @endforeach
    </div>
    <div style="text-align: center;">
        <form class="form-inline" action="{{ route('flopBet') }}" method="POST">
            @csrf
            <input type="number" name="bet" class="form-control" min="1" max="{{ $players[0]->getStack() }}"
                   placeholder="Type Your bet">
            <button type="submit" class="btn btn-success mb-2">Bet</button>
        </form>
        <br>
        <form style="display: inline;" class="form-inline" action="{{ route('flopBet') }}" method="POST">
            @csrf
            <input hidden="hidden" type="number" name="bet" class="form-control" value="{{ $players[0]->getStack() }}">
            <button type="submit" class="btn btn-info mb-2">All in</button>
        </form>

        <form style="display: inline;" class="form-inline" action="{{ route('flopBet') }}" method="POST">
            @csrf
            <input hidden="hidden" type="number" name="bet" class="form-control" value="0">
            <button type="submit" class="btn btn-secondary mb-2">Check</button>
        </form>

        <form style="display: inline;" class="form-inline" action="{{ route('poker-game-delete') }}">
            @csrf
            <button type="submit" class="btn btn-danger mb-2">Fall</button>
        </form>
        <br>
        <a href="{{ route('turn') }}">
            <button type="button" class="btn btn-primary btn-lg">Get turn</button>
        </a>
    </div>
    <br>
    <br>
    <a href="{{ route('poker-game-delete') }}">
        <button type="button" class="btn btn-warning">Start Over</button>
    </a>
    <a href="{{ route('choose-game') }}">
        <button type="button" class="btn btn-dark">Switch game</button>
    </a>
@endsection
