<?php /** @var App\Game\Card[] $pocketCards */ ?>
@extends('blackjack-template')
@foreach($pocketCards as $card)
    <img src="{{ $card->getAsImagePath() }}" alt="{{ $card->getAsString() }}">
@endforeach

@section('content')
    <br>

    <button type="button" disabled class="btn btn-primary">
        Your scores <span class="badge badge-light"> {{ $gamerPoints }}</span>
        <span class="sr-only"></span>
    </button>

    <a href="{{ route('one-more-card-page') }}">
        <button type="button" class="btn btn-danger">One more card</button>
    </a><br>
    <br>
    <a href="{{ route('stop-game-page') }}">
        <button type="button" class="btn btn-success">Stop</button>

    </a><br><br>  Next card busting:  {{ $gamerProbability }} percentage <br><br>
    <br>
    <a href="/game-delete">
        <button type="button" class="btn btn-warning">Start Over</button>
    </a>
@endsection



