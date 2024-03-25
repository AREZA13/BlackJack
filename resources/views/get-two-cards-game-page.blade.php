@extends('start-game-page')
@section('content')
@foreach($pocketCards as $card) {{
var_dump($card->getAsString())
}}
@endforeach
</body>
<footer>
    @yield('footer')
</footer>
</html>
