<div class="auth-card reveal">
    <div class="row" style="justify-content:space-between;align-items:center;margin-bottom:24px">
        <div class="row" style="gap:12px">
            <img src="{{ \App\Support\DiscordSession::avatarUrl($user) }}" alt="" style="width:40px;height:40px;border-radius:50%">
            <div>
                <div style="color:var(--ink);font-weight:600">{{ \App\Support\DiscordSession::displayName($user) }}</div>
                <div class="text-sm text-dim">Connecté avec Discord — vous êtes le chef d'équipe</div>
            </div>
        </div>
        <form method="POST" action="{{ route('auth.logout') }}">
            @csrf
            <button type="submit" class="btn btn--ghost btn--sm">Se déconnecter</button>
        </form>
    </div>

    <h2>Inscrire mon équipe</h2>
    <p class="text-muted">
        Vous comptez automatiquement comme le 1<sup>er</sup> titulaire. Renseignez
        le nom de l'équipe, puis l'identifiant Discord et le pseudo de vos
        {{ $event['teamSize'] - 1 }} autres titulaires. Les remplaçants sont facultatifs.
    </p>

    <div class="note mt-16">
        <p>
            Pour récupérer l'identifiant Discord d'un joueur : activer le
            <strong>mode développeur</strong> dans Discord (Paramètres → Avancés),
            puis clic droit sur son pseudo → <strong>« Copier l'identifiant »</strong>.
        </p>
    </div>

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
            Autres titulaires ({{ $event['teamSize'] - 1 }})
        </h3>

        @for($i = 0; $i < $event['teamSize'] - 1; $i++)
            <div class="field-pair" style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                <div class="field">
                    <label for="playerId{{ $i }}">Joueur {{ $i + 2 }} — ID Discord</label>
                    <input type="text" id="playerId{{ $i }}" name="playerId{{ $i }}" required
                           value="{{ $oldInput['playerId' . $i] ?? '' }}"
                           placeholder="123456789012345678" inputmode="numeric">
                    @if(!empty($fieldErrors['playerId' . $i]))
                        <p class="field__error">{{ $fieldErrors['playerId' . $i] }}</p>
                    @endif
                </div>
                <div class="field">
                    <label for="playerTag{{ $i }}">Joueur {{ $i + 2 }} — Pseudo</label>
                    <input type="text" id="playerTag{{ $i }}" name="playerTag{{ $i }}" required
                           value="{{ $oldInput['playerTag' . $i] ?? '' }}"
                           placeholder="pseudo_discord">
                    @if(!empty($fieldErrors['playerTag' . $i]))
                        <p class="field__error">{{ $fieldErrors['playerTag' . $i] }}</p>
                    @endif
                </div>
            </div>
        @endfor

        <h3 class="mt-24" style="font-size:15px;text-transform:uppercase;letter-spacing:.08em;color:var(--dim)">
            Remplaçants (facultatif, {{ $event['substitutes'] }} max.)
        </h3>

        @for($i = 0; $i < $event['substitutes']; $i++)
            <div class="field-pair" style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                <div class="field">
                    <label for="subId{{ $i }}">Remplaçant {{ $i + 1 }} — ID Discord</label>
                    <input type="text" id="subId{{ $i }}" name="subId{{ $i }}"
                           value="{{ $oldInput['subId' . $i] ?? '' }}"
                           placeholder="123456789012345678 (optionnel)" inputmode="numeric">
                    @if(!empty($fieldErrors['subId' . $i]))
                        <p class="field__error">{{ $fieldErrors['subId' . $i] }}</p>
                    @endif
                </div>
                <div class="field">
                    <label for="subTag{{ $i }}">Remplaçant {{ $i + 1 }} — Pseudo</label>
                    <input type="text" id="subTag{{ $i }}" name="subTag{{ $i }}"
                           value="{{ $oldInput['subTag' . $i] ?? '' }}"
                           placeholder="pseudo_discord (optionnel)">
                    @if(!empty($fieldErrors['subTag' . $i]))
                        <p class="field__error">{{ $fieldErrors['subTag' . $i] }}</p>
                    @endif
                </div>
            </div>
        @endfor

        <button type="submit" class="btn btn--primary mt-32">Valider l'inscription</button>

        <p class="text-sm text-dim mt-16">
            Votre équipe sera examinée par le staff avant de figurer dans le classement.
        </p>
    </form>
</div>
