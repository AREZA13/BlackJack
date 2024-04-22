@php
    use App\Game\Poker\Player;
@endphp

<?php
/** @var Player[] $players */
/** @var int $pot */
/** @var array $tableCards */
?>

@extends('poker/template')
@section('title', 'Poker River Round')

@include('poker/components/background')

@section('content')
    @include('poker/components/total-pot-button')
    @include('poker/components/show-result-cards')
    @include('poker/components/startover-switch-buttons')
@endsection
