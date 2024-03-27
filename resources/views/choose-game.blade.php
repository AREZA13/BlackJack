@extends('blackjack/template')
@section('content')
    <div style="text-align: center;">

        <a href="{{ route('blackjack-start-game-page') }}">
            <button type="button" class="btn btn-warning">Play BlackJack</button>
        </a>

        <a href="{{ route('blackjack-game-delete') }}">
            <button type="button" class="btn btn-secondary">Play Texas Holdem</button>
        </a>
    </div>
@endsection
