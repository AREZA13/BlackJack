@extends('blackjack/template')
@section('content')
    <style>
        body {
            background-image: url('../../images/front/bgForChooseGame.webp');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: 100% 100%;
        }
    </style>
    <div style="text-align: center;">
        <a href="{{ route('blackjack-start-game-page') }}">
            <button type="button" class="btn btn-warning"><h1>Play BlackJack</h1></button>
        </a>
        <button type='button' disabled class='btn btn-danger'><h1>Choose Game to Play</h1></button>
        <a href="{{ route('poker-start-game-page') }}">
            <button type="button" class="btn btn-secondary"><h1>Play Texas Holdem</h1></button>
        </a>

    </div>

@endsection
