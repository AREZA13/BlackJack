@php use App\Game\Poker\Player; @endphp
<?php
/** @var Player[] $players */
/** @var int $pot */
/** @var array $tableCards */

?>
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
    <div style="text-align: center;">
        <button type="button" class="btn btn-primary btn-lg" disabled>Total Pot {{$pot}}</button>
    </div>
    <br>

    <div style="text-align: center;">
        @foreach($players as $player)
            <div>
                @foreach($player->getPocketCards() as $card)
                    <img src="{{ $card->getAsImagePath() }}" alt="{{ $card->getAsString() }}">
                @endforeach

            </div>
        @endforeach
        <br>
    </div>



    <div style="text-align: center;">
        <form class="form-inline" name="formBet" action="{{ route('preFlopBet') }}" method="POST">
            @csrf
            <input type="number" style="display: inline" id="input" name="bet" class="form-control" min="1"
                   max="{{ $players[0]->getStack() }}"
                   placeholder="Type Your bet">
            <button type="submit" style="display: inline" name="betButton" id="betButton" class="btn btn-success mb-2">
                Bet
            </button>

        </form>

        <a href="{{ route('flop') }}">
            <button type="button" name="getFlop" id="getFlop" hidden="hidden" class="btn btn-primary btn-lg">Get flop
            </button>
        </a>
        <br>


        <br>
        <form style="display: inline;" class="form-inline" action="{{ route('preFlopBet') }}" method="POST">
            @csrf
            <input hidden="hidden" type="number" name="bet" class="form-control" value="{{ $players[0]->getStack() }}">
            <button type="submit" style="display: inline" id="allIn" class="btn btn-info mb-2">All in</button>
        </form>

        <form style="display: inline;" class="form-inline" action="{{ route('preFlopBet') }}" method="POST">
            @csrf
            <input hidden="hidden" type="number" name="bet" class="form-control" value="0">
            <button type="submit" style="display: inline" id="check" class="btn btn-secondary mb-2">Check</button>
        </form>

        <form style="display: inline;" class="form-inline" action="{{ route('poker-game-delete') }}">
            @csrf
            <button type="submit" style="display: inline" id="fall" class="btn btn-danger mb-2">Fall</button>
        </form>


        <script>
            const betButton = document.getElementById("betButton");
            const getFlop = document.getElementById("getFlop");
            const betInput = document.getElementById("input");
            const allIn = document.getElementById("allIn");
            const check = document.getElementById("check");
            const fall = document.getElementById("fall");

            getFlop.removeAttribute("hidden");
            betInput.style['display'] = 'none';
            betButton.style['display'] = 'none';
            fall.style['display'] = 'none';
            allIn.style['display'] = 'none';
            check.style['display'] = 'none';
        </script>

    </div>
    <br>
    <br>
    <a href="{{ route('poker-game-delete') }}">
        <button type="button" class="btn btn-warning">Start Over</button>
    </a>
    <a href="{{ route('choose-game') }}">
        <button type="button" class="btn btn-dark">Switch game</button>
    </a>

@endsection
