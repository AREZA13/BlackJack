@extends('start-game-page')
@section('content')
@foreach($pocketCards as $card) {{
var_dump($card->getAsString())
}}
@endforeach
<br>
<a href="{{route('one-more-card-page')}}"><button type="button" class="btn btn-primary">One more card</button></a><br>
<a href="{{route('stop-game-page')}}"><button type="button" class="btn btn-primary">Stop</button></a>
</body>
<footer>
    @yield('footer')
</footer>
</html>
