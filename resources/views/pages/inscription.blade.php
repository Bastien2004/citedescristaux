<x-layout title="Inscription" description="Inscrivez votre équipe pour la Cité des Cristaux — Alpha Games. Connexion Discord obligatoire.">

    @include('partials.page-header', [
        'kicker' => 'Inscription',
        'title' => 'Inscrire',
        'accent' => 'mon équipe',
        'lead' => "Connectez-vous avec Discord, réunissez vos {$event['teamSize']} joueurs et validez votre inscription.",
    ])

    <section class="section">
        <div class="container" style="max-width:760px">

            @if($errorMessage)
                <div class="note note--gold mb-24"><p>{{ $errorMessage }}</p></div>
            @endif

            @if(session('inscription_ok'))
                <div class="note mb-24" style="border-color:rgba(120,220,160,.35);background:rgba(120,220,160,.06)">
                    <p><strong>Votre équipe a bien été enregistrée !</strong> Elle sera examinée par le
                    staff, qui la validera avant qu'elle apparaisse dans le classement.</p>
                </div>
            @endif

            @if($formError)
                <div class="note note--gold mb-24"><p>{{ $formError }}</p></div>
            @endif

            @if($dbError)
                <div class="note note--gold mb-24">
                    <p>Le service d'inscription est momentanément indisponible. Réessayez dans un instant.</p>
                </div>

            @elseif(!$user)
                {{-- Étape 1 : connexion Discord --}}
                <div class="auth-card reveal text-center">
                    <div class="auth-card__icon">
                        <svg width="34" height="34" viewBox="0 0 24 24" fill="currentColor"><path d="M20.317 4.369A19.79 19.79 0 0 0 15.885 3l-.222.451a13.5 13.5 0 0 1 3.9 1.246 13.85 13.85 0 0 0-16.926 0 13.5 13.5 0 0 1 3.9-1.246L6.315 3a19.79 19.79 0 0 0-4.432 1.369C-.457 9.09-.833 13.68.29 18.196a19.9 19.9 0 0 0 5.993 3.03l.973-1.588a12.9 12.9 0 0 1-2.045-.98c.172-.126.34-.257.502-.392a14.2 14.2 0 0 0 12.574 0c.163.135.33.266.502.392a12.9 12.9 0 0 1-2.045.98l.973 1.588a19.85 19.85 0 0 0 5.993-3.03c1.319-5.148-.267-9.68-3.393-13.827ZM8.02 15.331c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.955-2.419 2.157-2.419 1.211 0 2.176 1.096 2.157 2.42 0 1.333-.955 2.418-2.157 2.418Zm7.96 0c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.955-2.419 2.157-2.419 1.211 0 2.176 1.096 2.157 2.42 0 1.333-.946 2.418-2.157 2.418Z"/></svg>
                    </div>
                    <h2>Connexion requise</h2>
                    <p class="text-muted">
                        L'inscription se fait avec le compte Discord du chef d'équipe.
                        Aucune autre donnée que votre identifiant, votre pseudo et votre avatar
                        n'est utilisée.
                    </p>

                    @if($notYetOpen)
                        <div class="note mt-24"><p>Les inscriptions ouvrent le
                            {{ \Illuminate\Support\Carbon::parse($event['registrationOpen'])->locale('fr')->isoFormat('D MMMM à HH[h]mm') }}.</p></div>
                    @elseif($closed)
                        <div class="note note--gold mt-24"><p>Les inscriptions sont fermées depuis le
                            {{ \Illuminate\Support\Carbon::parse($event['registrationClose'])->locale('fr')->isoFormat('D MMMM à HH[h]mm') }}.</p></div>
                    @else
                        <a href="{{ route('auth.discord', ['next' => '/inscription']) }}" class="btn btn--primary mt-24">
                            Se connecter avec Discord
                        </a>
                    @endif
                </div>

            @elseif($team)
                {{-- Étape 3 : équipe déjà inscrite --}}
                <div class="auth-card reveal">
                    <div class="row" style="justify-content:space-between;align-items:center;margin-bottom:20px">
                        <div class="row" style="gap:12px">
                            <img src="{{ \App\Support\DiscordSession::avatarUrl($user) }}" alt="" style="width:40px;height:40px;border-radius:50%">
                            <div>
                                <div style="color:var(--ink);font-weight:600">{{ \App\Support\DiscordSession::displayName($user) }}</div>
                                <div class="text-sm text-dim">Chef d'équipe</div>
                            </div>
                        </div>
                        <span class="pill {{ $team->status === 'VALIDATED' ? '' : ($team->status === 'REJECTED' ? 'pill--gold' : 'pill--red') }}"
                              style="{{ $team->status === 'VALIDATED' ? 'border-color:rgba(120,220,160,.4);color:#9be8b6' : '' }}">
                            {{ $team->status === 'VALIDATED' ? 'Équipe validée' : ($team->status === 'REJECTED' ? 'Inscription refusée' : 'En attente de validation') }}
                        </span>
                    </div>

                    <h2 style="font-size:26px">{{ $team->name }}</h2>

                    <h3 class="mt-24" style="font-size:15px;text-transform:uppercase;letter-spacing:.08em;color:var(--dim)">Titulaires</h3>
                    <ul class="checklist">
                        @foreach($team->members->where('role', 'TITULAIRE') as $m)
                            <li><span class="bullet"></span><span>{{ $m->discord_tag }}{{ $m->is_captain ? ' (chef)' : '' }}</span></li>
                        @endforeach
                    </ul>

                    @if($team->members->where('role', 'REMPLACANT')->isNotEmpty())
                        <h3 class="mt-24" style="font-size:15px;text-transform:uppercase;letter-spacing:.08em;color:var(--dim)">Remplaçants</h3>
                        <ul class="checklist">
                            @foreach($team->members->where('role', 'REMPLACANT') as $m)
                                <li><span class="bullet"></span><span>{{ $m->discord_tag }}</span></li>
                            @endforeach
                        </ul>
                    @endif

                    <div class="note mt-24">
                        <p>Pour modifier la composition de votre équipe, contactez le staff sur le
                        Discord Alpha.</p>
                    </div>

                    <form method="POST" action="{{ route('auth.logout') }}" class="mt-24">
                        @csrf
                        <button type="submit" class="btn btn--ghost btn--sm">Se déconnecter</button>
                    </form>
                </div>

            @else
                {{-- Étape 2 : formulaire d'inscription --}}
                @if($closed)
                    <div class="note note--gold text-center reveal">
                        <p>Les inscriptions sont fermées depuis le
                        {{ \Illuminate\Support\Carbon::parse($event['registrationClose'])->locale('fr')->isoFormat('D MMMM à HH[h]mm') }}.</p>
                    </div>
                @else
                    @include('pages.inscription-form')
                @endif
            @endif
        </div>
    </section>
</x-layout>
