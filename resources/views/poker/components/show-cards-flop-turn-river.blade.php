<div style="text-align: center;">
    @foreach($players as $player)
        <div>
            @foreach($player->getPocketCards() as $card)
                <img src="{{ $card->getAsImagePath() }}" alt="{{ $card->getAsString() }}">
            @endforeach
        </div>
        <br>
    @endforeach
    <br>
    @foreach($tableCards as $tableCard)
        <img src="{{ $tableCard->getAsImagePath() }}" alt="{{ $tableCard->getAsString() }}">
    @endforeach
    <br>
    <br>
</div>
