@extends('poker/template')

@section('title', 'Start Texas Holdem')

@include('poker/components/background')

@section('content')
    <a href="{{ route('pokerGet') }}">
        <button type="button" class="btn btn-primary">Start game</button>
    </a>
    <a href="{{ route('choose-game') }}">
        <button type="button" class="btn btn-dark">Switch game</button>
    </a>
@endsection
