@extends('start-game-page')
@foreach($pocketCards as $card)
    {{ $card->getAsTwoLettersString() }}
@endforeach
@yield('content')
<br>

<br>
<a href="{{ route('one-more-card-page') }}">
    <button type="button" class="btn btn-primary">One more card</button>
</a><br>
<a href="{{ route('stop-game-page') }}">
    <button type="button" class="btn btn-primary">Stop</button>

</a><br><br>  Next card busting:  {{ $gamerProbability }} percentage <br><br>




