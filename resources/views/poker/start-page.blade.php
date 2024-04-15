@extends('poker/template')
@section('content')
    <style>
        body {
            background-image: url('../../images/front/bgForFinishGame.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: 100% 100%;
        }
    </style>
    <a href="{{ route('preFlop') }}">
        <button type="button" class="btn btn-primary">Start game</button>
    </a>
    <a href="{{ route('choose-game') }}">
        <button type="button" class="btn btn-dark">Switch game</button>
    </a>

    <a href="{{ route('poker-game-delete') }}">
        <button type="button" class="btn btn-warning">Start Over</button>
    </a>


@endsection
