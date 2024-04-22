<div style="text-align: center;">

        <div>
            @foreach($players[1]->getPocketCards() as $card)
                <img src="{{ $card->getAsBackCardImage() }}">
            @endforeach
            @foreach($players[2]->getPocketCards() as $card)
                <img src="{{ $card->getAsBackCardImage() }}">
            @endforeach
        </div>
    <br>
    @foreach($players[0]->getPocketCards() as $card)
        <img src="{{ $card->getAsImagePath() }}" alt="{{ $card->getAsString() }}">
    @endforeach
    <br>
    <br>
</div>
