<div class="auth-card reveal">
    <div class="row" style="justify-content:space-between;align-items:center;margin-bottom:24px">
        <div class="row" style="gap:12px">
            <img src="{{ \App\Support\DiscordSession::avatarUrl($user) }}" alt="" style="width:40px;height:40px;border-radius:50%">
            <div>
                <div style="color:var(--ink);font-weight:600">{{ \App\Support\DiscordSession::displayName($user) }}</div>
                <div class="text-sm text-dim">Connecté avec Discord</div>
            </div>
        </div>
        <form method="POST" action="{{ route('auth.logout') }}">
            @csrf
            <button type="submit" class="btn btn--ghost btn--sm">Se déconnecter</button>
        </form>
    </div>

    <h2>Inscrire mon équipe</h2>
    <p class="text-muted">
        Renseignez le nom de votre équipe et le pseudo Discord de vos
        {{ $event['teamSize'] }} titulaires. Les remplaçants sont facultatifs.
    </p>

    <form method="POST" action="{{ route('inscription.store') }}" class="form mt-24">
        @csrf

        <div class="field">
            <label for="teamName">Nom de l'équipe</label>
            <input type="text" id="teamName" name="teamName" minlength="3" maxlength="32" required
                   value="{{ $oldInput['teamName'] ?? '' }}"
                   placeholder="Ex. Les Gardiens du Cristal">
            @if(!empty($fieldErrors['teamName']))
                <p class="field__error">{{ $fieldErrors['teamName'] }}</p>
            @endif
        </div>

        <h3 class="mt-24" style="font-size:15px;text-transform:uppercase;letter-spacing:.08em;color:var(--dim)">
            Titulaires ({{ $event['teamSize'] }})
        </h3>

        @for($i = 0; $i < $event['teamSize']; $i++)
            <div class="field">
                <label for="player{{ $i }}">
                    Joueur {{ $i + 1 }}{{ $i === 0 ? ' (vous, chef d\'équipe)' : '' }}
                </label>
                <input type="text" id="player{{ $i }}" name="player{{ $i }}" required
                       value="{{ $oldInput['player' . $i] ?? '' }}"
                       placeholder="pseudo_discord">
                @if(!empty($fieldErrors['player' . $i]))
                    <p class="field__error">{{ $fieldErrors['player' . $i] }}</p>
                @endif
            </div>
        @endfor

        <h3 class="mt-24" style="font-size:15px;text-transform:uppercase;letter-spacing:.08em;color:var(--dim)">
            Remplaçants (facultatif, {{ $event['substitutes'] }} max.)
        </h3>

        @for($i = 0; $i < $event['substitutes']; $i++)
            <div class="field">
                <label for="sub{{ $i }}">Remplaçant {{ $i + 1 }}</label>
                <input type="text" id="sub{{ $i }}" name="sub{{ $i }}"
                       value="{{ $oldInput['sub' . $i] ?? '' }}"
                       placeholder="pseudo_discord (optionnel)">
                @if(!empty($fieldErrors['sub' . $i]))
                    <p class="field__error">{{ $fieldErrors['sub' . $i] }}</p>
                @endif
            </div>
        @endfor

        <button type="submit" class="btn btn--primary mt-32">Valider l'inscription</button>

        <p class="text-sm text-dim mt-16">
            Votre équipe sera examinée par le staff avant de figurer dans le classement.
        </p>
    </form>
</div>
