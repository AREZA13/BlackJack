@extends('blackjack-template')
@section('content')
   {!! $message !!} <br>
   <br>
   <a href="/game-delete">
       <button type="button" class="btn btn-warning">Start Over</button>
   </a>
@endsection
