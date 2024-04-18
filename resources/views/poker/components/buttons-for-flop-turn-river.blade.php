<div style="text-align: center;">
    <form class="form-inline" action="{{ $pageUrl }}" method="POST">
        @csrf
        <input type="number" name="bet" class="form-control" value="1" min="1" max="{{ $players[0]->getStack() }}"
               placeholder="Type Your bet">
        <button type="submit" class="btn btn-success mb-2">Bet</button>
    </form>
    <br>
    <form style="display: inline;" class="form-inline" action="{{ route('allInBet') }}" method="POST">
        @csrf
        <input hidden="hidden" type="number" name="bet" class="form-control" value="{{ $players[0]->getStack() }}">
        <button type="submit" class="btn btn-info mb-2">All in</button>
    </form>

    <form style="display: inline;" class="form-inline" action="{{ $pageUrl }}" method="POST">
        @csrf
        <input hidden="hidden" type="number" name="bet" class="form-control" value="0">
        <button type="submit" class="btn btn-secondary mb-2">Check</button>
    </form>

    <form style="display: inline;" class="form-inline" action="{{ route('poker-game-delete') }}">
        @csrf
        <button type="submit" class="btn btn-danger mb-2">Fall</button>
    </form>
</div>
