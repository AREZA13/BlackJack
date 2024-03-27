@extends('blackjack/template')
@section('content')
    <a href="{{ route('blackjack-get-two-cards-game-page') }}">
        <button type="button" class="btn btn-primary">Start game</button>
    </a>
    <a href="{{ route('choose-game') }}">
        <button type="button" class="btn btn-dark">Switch game</button>
    </a>

@endsection
