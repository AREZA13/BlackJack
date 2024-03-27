@extends('blackjack-template')
@section('content')
    <div style="text-align: center;">
   {!! $message !!} <br>
   <br>
   <a href="/game-delete">
       <button type="button" class="btn btn-warning">Start Over</button>
   </a>
    </div>
@endsection
