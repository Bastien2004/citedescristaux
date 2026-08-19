<x-layout title="Admin">

    @if($step === 'login')
        {{-- Non connecté --}}
        <section class="section" style="padding-top:160px">
            <div class="container" style="max-width:520px">
                <div class="auth-card text-center reveal">
                    <h2>Panel administrateur</h2>
                    <p class="text-muted">Connectez-vous avec le compte Discord autorisé pour accéder au panel.</p>
                    <a href="{{ route('auth.discord', ['next' => '/admin']) }}" class="btn btn--primary mt-24">
                        Se connecter avec Discord
                    </a>
                </div>
            </div>
        </section>

    @elseif($step === 'forbidden')
        {{-- Connecté mais pas admin --}}
        <section class="section" style="padding-top:160px">
            <div class="container" style="max-width:520px">
                <div class="auth-card text-center reveal">
                    <h2>Accès refusé</h2>
                    <p class="text-muted">
                        Le compte <strong>{{ \App\Support\DiscordSession::displayName($user) }}</strong>
                        n'a pas accès au panel administrateur.
                    </p>
                    <form method="POST" action="{{ route('auth.logout') }}" class="mt-24">
                        @csrf
                        <button type="submit" class="btn btn--ghost">Se déconnecter</button>
                    </form>
                </div>
            </div>
        </section>

    @else
        {{-- Panel complet --}}
        <section class="section" style="padding-top:150px">
            <div class="container">

                <div class="row" style="justify-content:space-between;align-items:center;margin-bottom:32px;flex-wrap:wrap;gap:16px">
                    <div>
                        <span class="kicker">Panel administrateur</span>
                        <h1 style="font-size:clamp(28px,3.4vw,40px);margin:10px 0 0">
                            {{ $viewerIsOwner ? 'Propriétaire' : 'Administrateur' }}
                        </h1>
                    </div>
                    <div class="row" style="gap:12px;align-items:center">
                        <img src="{{ \App\Support\DiscordSession::avatarUrl($user) }}" alt="" style="width:36px;height:36px;border-radius:50%">
                        <span class="text-sm">{{ \App\Support\DiscordSession::displayName($user) }}</span>
                        <form method="POST" action="{{ route('auth.logout') }}">
                            @csrf
                            <button type="submit" class="btn btn--ghost btn--sm">Se déconnecter</button>
                        </form>
                    </div>
                </div>

                @if($dbError)
                    <div class="note note--gold mb-24"><p>Erreur de base de données : {{ $dbError }}</p></div>
                @endif

                @if(session('admin_ok'))
                    <div class="note mb-24" style="border-color:rgba(120,220,160,.35);background:rgba(120,220,160,.06)">
                        <p>{{ session('admin_ok') }}</p>
                    </div>
                @endif
                @if(session('admin_error'))
                    <div class="note note--gold mb-24"><p>{{ session('admin_error') }}</p></div>
                @endif

                {{-- Onglets --}}
                <div class="chips mb-32">
                    @foreach($tabs as $t)
                        <a href="{{ route('admin.index', ['tab' => $t['key']]) }}"
                           class="chip {{ $tab === $t['key'] ? 'chip--active' : '' }}">
                            {{ $t['label'] }} ({{ $counts[$t['key']] }})
                        </a>
                    @endforeach
                </div>

                {{-- ---------------- CANDIDATURES ---------------- --}}
                @if($tab === 'candidatures')
                    @if($pending->isEmpty())
                        <div class="empty reveal">
                            <h3>Aucune candidature en attente</h3>
                            <p>Les nouvelles inscriptions apparaîtront ici.</p>
                        </div>
                    @else
                        <div class="admin-list">
                            @foreach($pending as $team)
                                <div class="admin-card">
                                    <div class="row" style="justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:12px">
                                        <div>
                                            <form method="POST" action="{{ route('admin.teams.name', $team) }}" class="row" style="gap:8px;align-items:center">
                                                @csrf
                                                <input type="text" name="name" value="{{ $team->name }}" class="input-sm" style="font-weight:600;font-size:18px;color:var(--ink);background:transparent;border:1px solid rgba(255,255,255,.12);border-radius:8px;padding:4px 10px">
                                                <button type="submit" class="btn btn--ghost btn--sm">Renommer</button>
                                            </form>
                                            <p class="text-sm text-dim" style="margin:8px 0 0">
                                                Chef : {{ $team->captain_tag }} · inscrite le {{ $team->created_at->locale('fr')->isoFormat('D MMM YYYY à HH:mm') }}
                                            </p>
                                        </div>
                                        <div class="row" style="gap:8px">
                                            <form method="POST" action="{{ route('admin.teams.accept', $team) }}">
                                                @csrf
                                                <button type="submit" class="btn btn--primary btn--sm">Accepter</button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.teams.reject', $team) }}">
                                                @csrf
                                                <button type="submit" class="btn btn--ghost btn--sm">Refuser</button>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="admin-card__members mt-16" style="display:flex;flex-direction:column;gap:8px">
                                        @foreach($team->members as $m)
                                            @include('partials.admin-member-edit', ['team' => $team, 'member' => $m])
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- ---------------- ÉQUIPES ---------------- --}}
                @elseif($tab === 'equipes')
                    @if($validated->isEmpty())
                        <div class="empty reveal">
                            <h3>Aucune équipe validée</h3>
                            <p>Acceptez des candidatures pour les faire apparaître ici et dans le classement public.</p>
                        </div>
                    @else
                        <div class="admin-list">
                            @foreach($validated as $team)
                                <div class="admin-card">
                                    <div class="row" style="justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:12px">
                                        <div>
                                            <form method="POST" action="{{ route('admin.teams.name', $team) }}" class="row" style="gap:8px;align-items:center">
                                                @csrf
                                                <input type="text" name="name" value="{{ $team->name }}" class="input-sm" style="font-weight:600;font-size:18px;color:var(--ink);background:transparent;border:1px solid rgba(255,255,255,.12);border-radius:8px;padding:4px 10px">
                                                <button type="submit" class="btn btn--ghost btn--sm">Renommer</button>
                                            </form>
                                            <p class="text-sm text-dim" style="margin:8px 0 0">Chef : {{ $team->captain_tag }}</p>
                                        </div>

                                        <div class="row" style="gap:8px;align-items:center;flex-wrap:wrap">
                                            <form method="POST" action="{{ route('admin.teams.points', $team) }}" class="row" style="gap:6px">
                                                @csrf
                                                <input type="number" name="points" value="{{ $team->points }}" style="width:100px" class="input-sm">
                                                <button type="submit" class="btn btn--ghost btn--sm">Mettre à jour</button>
                                            </form>

                                            <form method="POST" action="{{ route('admin.teams.unlist', $team) }}">
                                                @csrf
                                                <button type="submit" class="btn btn--ghost btn--sm">Repasser en attente</button>
                                            </form>

                                            <form method="POST" action="{{ route('admin.teams.delete', $team) }}">
                                                @csrf
                                                <button type="submit" class="btn btn--ghost btn--sm" data-confirm="Supprimer définitivement l'équipe « {{ $team->name }} » ?">
                                                    Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="admin-card__members mt-16" style="display:flex;flex-direction:column;gap:8px">
                                        @foreach($team->members as $m)
                                            @include('partials.admin-member-edit', ['team' => $team, 'member' => $m])
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if($rejected->isNotEmpty())
                        <h3 class="mt-48" style="font-size:15px;text-transform:uppercase;letter-spacing:.08em;color:var(--dim)">
                            Candidatures refusées ({{ $rejected->count() }})
                        </h3>
                        <div class="admin-list mt-16">
                            @foreach($rejected as $team)
                                <div class="admin-card">
                                    <div class="row" style="justify-content:space-between;align-items:center">
                                        <span>{{ $team->name }} — {{ $team->captain_tag }}</span>
                                        <div class="row" style="gap:8px">
                                            <form method="POST" action="{{ route('admin.teams.unlist', $team) }}">
                                                @csrf
                                                <button type="submit" class="btn btn--ghost btn--sm">Remettre en attente</button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.teams.delete', $team) }}">
                                                @csrf
                                                <button type="submit" class="btn btn--ghost btn--sm" data-confirm="Supprimer définitivement l'équipe « {{ $team->name }} » ?">Supprimer</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- ---------------- ADMINS ---------------- --}}
                @elseif($tab === 'admins')
                    <h3 style="font-size:15px;text-transform:uppercase;letter-spacing:.08em;color:var(--dim)">
                        Propriétaires (via .env, non modifiables)
                    </h3>
                    <div class="admin-list mt-16 mb-32">
                        @foreach($owners as $ownerId)
                            <div class="admin-card">
                                <div class="row" style="justify-content:space-between;align-items:center">
                                    <span>{{ $ownerId }}</span>
                                    <span class="pill pill--gold">Propriétaire</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <h3 style="font-size:15px;text-transform:uppercase;letter-spacing:.08em;color:var(--dim)">
                        Administrateurs ajoutés
                    </h3>
                    <div class="admin-list mt-16">
                        @forelse($admins as $a)
                            <div class="admin-card">
                                <div class="row" style="justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px">
                                    <span>{{ $a->label ?: $a->discord_id }} <span class="text-sm text-dim">({{ $a->discord_id }})</span></span>
                                    <form method="POST" action="{{ route('admin.admins.remove') }}">
                                        @csrf
                                        <input type="hidden" name="discordId" value="{{ $a->discord_id }}">
                                        <button type="submit" class="btn btn--ghost btn--sm" data-confirm="Retirer l'accès admin de {{ $a->label ?: $a->discord_id }} ?">
                                            Retirer l'accès
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="text-dim">Aucun administrateur ajouté pour le moment.</p>
                        @endforelse
                    </div>

                    @if($viewerIsOwner)
                        <div class="auth-card mt-32" style="max-width:480px">
                            <h3 style="margin-top:0">Ajouter un administrateur</h3>
                            <form method="POST" action="{{ route('admin.admins.add') }}" class="form mt-16">
                                @csrf
                                <div class="field">
                                    <label for="discordId">Identifiant Discord</label>
                                    <input type="text" id="discordId" name="discordId" required placeholder="123456789012345678">
                                </div>
                                <div class="field">
                                    <label for="label">Nom (facultatif)</label>
                                    <input type="text" id="label" name="label" placeholder="Pseudo affiché">
                                </div>
                                <button type="submit" class="btn btn--primary mt-16">Ajouter</button>
                            </form>
                        </div>
                    @endif
                @endif
            </div>
        </section>
    @endif
</x-layout>
