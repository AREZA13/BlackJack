@extends('blackjack/template')
@section('content')
    <div style="text-align: center;">
   <br>
   <a href="{{ route('blackjack-game-delete') }}">
       <button type="button" class="btn btn-warning">Start Over</button>
   </a>
    </div>
@endsection
