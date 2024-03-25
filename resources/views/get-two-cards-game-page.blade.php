@extends('start-game-page')
@section('content')
<button type="button">Start Game</button>
<a href="{{route('get-two-cards-game-page')}}"><button type="button">Primary</button></a>
</body>
<footer>
    @yield('footer')
</footer>
</html>
