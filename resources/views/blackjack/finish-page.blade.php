@extends('blackjack/template')
@section('content')
    <style>
        body {
            background-image: url('../../images/front/bgForFinishGame.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: 100% 100%;
        }
    </style>

    <div style="text-align: center;">
        {!! $message !!} <br>
        <br>
        <a href="{{ route('blackjack-game-delete') }}">
            <button type="button" class="btn btn-warning">Start Over</button>
        </a>
        <a href="{{ route('choose-game') }}">
            <button type="button" class="btn btn-dark">Switch game</button>
        </a>
    </div>

@endsection
