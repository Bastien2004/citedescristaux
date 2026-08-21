<div class="player-slot {{ $member->role === 'REMPLACANT' ? 'player-slot--sub' : '' }}">
    <div class="player-num {{ $member->role === 'REMPLACANT' ? 'player-num--sub' : '' }}">
        {{ $member->is_captain ? 'C' : ($member->role === 'REMPLACANT' ? 'R' . $member->position : $member->position) }}
    </div>
    <div style="flex:1;min-width:0">
        <div class="player-slot__label">
            {{ $member->role === 'REMPLACANT' ? 'Remplaçant' : 'Titulaire' }}{{ $member->is_captain ? " — Chef d'équipe" : '' }}
        </div>
        <form method="POST" action="{{ route('admin.teams.members.update', ['team' => $team, 'member' => $member]) }}" class="member-fields">
            @csrf
            <input type="text" name="discordId" value="{{ $member->discord_id }}" placeholder="ID Discord" class="input-sm">
            <input type="text" name="discordTag" value="{{ $member->discord_tag }}" placeholder="Pseudo" class="input-sm">
            <button type="submit" class="btn btn--ghost btn--sm">Enregistrer</button>
        </form>
    </div>
</div>
