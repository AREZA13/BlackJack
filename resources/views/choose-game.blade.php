@extends('blackjack/template')
@section('content')
    <style>
        body {
            background-image: url('https://sweet-bonanza.co/wp-content/uploads/2024/02/fulgar-architects-anthurium-hotel-casino-tanauan-city-batangas-04b-1.webp');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: 100% 100%;
        }
    </style>
    {{--    https://opis-cdn.tinkoffjournal.ru/mercury/casino_cover_bg_2e1f33_hover_f9d7bf-1.mltn3e3bwo6k.jpg?preset=image_1280w--}}
    <div style="text-align: center;">
        <a href="{{ route('blackjack-start-game-page') }}">
            <button type="button" class="btn btn-warning"><h1>Play BlackJack</h1></button>
        </a>
        <button type='button' disabled class='btn btn-danger'><h1>Choose Game to Play</h1></button>
        <a href="{{ route('blackjack-game-delete') }}">
            <button type="button" class="btn btn-secondary"><h1>Play Texas Holdem</h1></button>
        </a>

    </div>

@endsection
