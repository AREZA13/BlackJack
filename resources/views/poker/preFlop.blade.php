<?php
/** @var \App\Game\Poker\Player[] $players */
/** @var int $pot */
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
        @foreach($players as $player)
            <div>
                @foreach($player->getPocketCards() as $card)
                    <img src="{{ $card->getAsImagePath() }}" alt="{{ $card->getAsString() }}">
                @endforeach
            </div>
        @endforeach
    </div>
    <form class="form-inline" method="GET">
        <div class="form-group mx-sm-3 mb-2">
            <br>
            <input type="bet" class="form-control" id="bet" placeholder="Type Your bet">
            <button type="submit" class="btn btn-warning mb-2">All in</button>
            <button type="submit" class="btn btn-success mb-2">Bet</button>
        </div>
    </form>
    <div style="text-align: center;">
        <button type="submit" class="btn btn-secondary mb-2">Check</button>
        <button type="submit" class="btn btn-danger mb-2">Fall</button>
    </div>

@endsection
