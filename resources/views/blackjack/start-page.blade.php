@extends('blackjack/template')
@section('content')
    <style>
        body {
            background-image: url('https://hippodromecasino.com/wp-content/uploads/2019/11/blackjack.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: 100% 100%;
        }
    </style>
    <a href="{{ route('blackjack-get-two-cards-game-page') }}">
        <button type="button" class="btn btn-primary">Start game</button>
    </a>
    <a href="{{ route('choose-game') }}">
        <button type="button" class="btn btn-dark">Switch game</button>
    </a>

@endsection
