<?php /** @var App\Game\Card[] $pocketCards */ ?>
@extends('blackjack/template')
<div style="text-align: center;">
    <button type="button" disabled class="btn btn-primary">
        Your scores <span class="badge badge-light"> {{ $gamerPoints }}</span>
        <span class="sr-only"></span>
    </button>
    <br><br>
    <div style="text-align: center;">
        @foreach($pocketCards as $card)
            <img src="{{ $card->getAsImagePath() }}" alt="{{ $card->getAsString() }}">
        @endforeach
    </div>

    @section('content')

        <br>
        @if ((21 - $gamerPoints) > 0)

            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                 style="width: {{ $gamerProbability }}%; text-align: center;" aria-valuenow="{{ $gamerProbability }}"
                 aria-valuemin="0" aria-valuemax="100">
            </div>
            <a href="{{ route('blackjack-one-more-card-page') }}">
                <button type="button" class="btn btn-danger">One more card</button>
            </a>
            <a href="{{ route('blackjack-stop-game-page') }}">
                <button type="button" class="btn btn-success">Stop</button>
            </a>
            <br>
            <br>
            Probability of next being more than {{ 21 - $gamerPoints }} scores is <span style="color: red;">{{ $gamerProbability }}% </span>
            <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                     style="width: {{ $gamerProbability }}%; text-align: center;"
                     aria-valuenow="{{ $gamerProbability }}"
                     aria-valuemin="0" aria-valuemax="100">
                    Bursted
                </div>
            </div>
        @elseif((21 - $gamerPoints) < 0)
            <button type="button" disabled class="btn btn-danger">
                You are bursted <span class="badge badge-light"></span>
                <span class="sr-only"></span>
            </button>
        @elseif((21 - $gamerPoints) === 0)
            <button type='button' disabled class='btn btn-success'>Victory</button>
        @endif
        <br>
        <br>
        <a href="{{ route('blackjack-game-delete') }}">
            <button type="button" class="btn btn-warning">Start Over</button>
        </a>
</div>
@endsection



