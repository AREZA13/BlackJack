@extends('blackjack-template')
@section('content')
    <a href="{{route('get-two-cards-game-page')}}">
        <button type="button" class="btn btn-primary">Start game</button>
    </a>

@endsection
