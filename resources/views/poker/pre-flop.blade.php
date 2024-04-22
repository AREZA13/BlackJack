@php
    use App\Game\Poker\Player;
@endphp
<?php
/** @var Player[] $players */
/** @var int $pot */
/** @var array $tableCards */
?>
@extends('poker/template')
@section('title', 'Poker Pre Flop Round')

@include('poker/components/background')

@section('content')
    @include('poker/components/total-pot-button')
    @include('poker.components/show-cards-preflop')
    @include('poker/components/buttons-for-flop-turn-river')
    @include('poker/components/startover-switch-buttons')
@endsection
