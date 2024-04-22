<div style="text-align: center;">
    <div>
        <br>
        <br>
        @foreach($players as $player)
            <br>
        @foreach($player->getPocketCards() as $card)
            <img src="{{ $card->getAsImagePath() }}" alt="{{ $card->getAsString() }}">
        @endforeach
            <br>
        @endforeach
    </div>
    <br>
    @foreach($tableCards as $tableCard)
        <img src="{{ $tableCard->getAsImagePath() }}" alt="{{ $tableCard->getAsString() }}">
    @endforeach
    <br>
    <br>
</div>
