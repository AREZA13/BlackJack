@extends('get-two-cards-game-page')
@section('content')
@foreach($pocketCards as $card) {{
var_dump($card->getAsString())
}}
@endforeach
    @yield('footer')
</footer>
</html>
