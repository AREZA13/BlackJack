@php
    use App\Game\Poker\Player;
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
        <br>
        <br>
        <div style="text-align: center;">
            <a href="{{ route('poker-game-delete') }}">
                <button type="button" class="btn btn-warning">Start Over</button>
            </a>
            <a href="{{ route('choose-game') }}">
                <button type="button" class="btn btn-dark">Switch game</button>
            </a>
        </div>
@endsection
