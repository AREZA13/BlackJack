@php use App\Game\Poker\Player; @endphp
<?php
/** @var Player[] $winnerPlayers */
/** @var array $tableCards */
?>
<div style="text-align: center;">
    <div style="text-align: center;">
        @foreach($winnerPlayers as $winnerPlayer)
            <br>
            <br>
            <button type="button" class="btn btn-primary btn-lg" disabled>Winner
                <span>{{ $winnerPlayer->getPlayerId() }}</span></button>
            <br>
            <br>
            @foreach($winnerPlayer->getPlayerHand($tableCards)->getCards() as $winnerCard)
                <img src="{{ $winnerCard->getAsImagePath() }}" alt="{{ $winnerCard->getAsImagePath() }}">
            @endforeach
        @endforeach
    </div>
</div>
