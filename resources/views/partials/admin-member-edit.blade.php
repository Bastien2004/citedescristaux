<form method="POST" action="{{ route('admin.teams.members.update', ['team' => $team, 'member' => $member]) }}"
      class="row" style="gap:8px;align-items:center;flex-wrap:wrap;background:rgba(255,255,255,.03);border-radius:10px;padding:8px 12px">
    @csrf
    <span class="text-sm text-dim" style="min-width:90px">
        {{ $member->role === 'REMPLACANT' ? 'Rempl.' : 'Titulaire' }}{{ $member->is_captain ? ' (chef)' : '' }}
    </span>
    <input type="text" name="discordId" value="{{ $member->discord_id }}" placeholder="ID Discord" class="input-sm" style="width:180px">
    <input type="text" name="discordTag" value="{{ $member->discord_tag }}" placeholder="Pseudo" class="input-sm" style="width:160px">
    <button type="submit" class="btn btn--ghost btn--sm">Enregistrer</button>
</form>
