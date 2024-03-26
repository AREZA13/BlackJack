<?php /** @var App\Game\Card[] $pocketCards */ ?>
@extends('start-game-page')
@foreach($pocketCards as $card)
     <img src="{{ $card->getAsImagePath() }}" alt="{{ $card->getAsString() }}">
@endforeach

@yield('content')
<br>

<br>
<a href="{{ route('one-more-card-page') }}">
    <button type="button" class="btn btn-danger">One more card</button>
</a><br>
<br>
<a href="{{ route('stop-game-page') }}">
    <button type="button" class="btn btn-success">Stop</button>

</a><br><br>  Next card busting:  {{ $gamerProbability }} percentage <br><br>




