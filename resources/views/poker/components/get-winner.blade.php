@php use App\Game\Poker\Player; @endphp
<?php
/** @var Player[] $winnerPlayers */
/** @var array $tableCards */
?>
<div style="text-align: center;">
    <div style="text-align: center;">
        <br>
        @foreach($winnerPlayers as $winnerPlayer)
            <span>{{ $winnerPlayer->getPlayerId() }}</span>
            @foreach($winnerPlayer->getPlayerHand($tableCards)->getCards() as $winnerCard)
                <br>
                <br>
                <img src="{{ $winnerCard->getAsImagePath() }}" alt="{{ $winnerCard->getAsImagePath() }}">
                <br>
                <br>
            @endforeach
        @endforeach
        <br>
    </div>
    <br>
</div>
