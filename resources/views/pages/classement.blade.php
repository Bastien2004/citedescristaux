<x-layout title="Classement" description="Le classement en direct des équipes de la Cité des Cristaux — Alpha Games.">

    @include('partials.page-header', [
        'kicker' => 'Classement',
        'title' => 'Le classement de',
        'accent' => 'la Cité',
        'lead' => "Mis à jour par le staff au fil de la semaine. Les points d'étape officiels sont annoncés à l'ONU.",
    ])

    <section class="section">
        <div class="container">
            @if($dbError)
                <div class="note note--gold text-center">
                    <p>Le classement est momentanément indisponible. Réessayez dans un instant.</p>
                </div>
            @elseif($teams->isEmpty())
                <div class="empty reveal">
                    <div class="empty__icon">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M8 21h8" /><path d="M12 17v4" /><path d="M7 4h10v5a5 5 0 0 1-10 0z" /><path d="M7 6H4a3 3 0 0 0 3 3" /><path d="M17 6h3a3 3 0 0 1-3 3" /></svg>
                    </div>
                    <h3>{{ $started ? "Le classement n'a pas encore été publié" : "La Cité n'a pas encore ouvert" }}</h3>
                    <p>
                        @if($started)
                            Les premiers scores seront affichés ici dès que le staff les aura communiqués.
                        @else
                            Le classement s'affichera ici une fois la Cité ouverte, le
                            {{ \Illuminate\Support\Carbon::parse($event['openingLive'])->locale('fr')->isoFormat('D MMMM à HH[h]mm') }}.
                        @endif
                    </p>
                    <a href="{{ url('/inscription') }}" class="btn btn--primary mt-16">Inscrire mon équipe</a>
                </div>
            @else
                <div class="table-wrap reveal">
                    <table class="ranking">
                        <thead>
                            <tr>
                                <th style="width:64px">Rang</th>
                                <th>Équipe</th>
                                <th style="width:110px">Membres</th>
                                <th style="width:140px;text-align:right">Points</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($teams as $i => $team)
                                <tr class="{{ $i < 3 ? 'ranking__row--top' : '' }}">
                                    <td>
                                        <span class="ranking__rank {{ $i === 0 ? 'ranking__rank--gold' : ($i === 1 ? 'ranking__rank--silver' : ($i === 2 ? 'ranking__rank--bronze' : '')) }}">
                                            {{ $i + 1 }}
                                        </span>
                                    </td>
                                    <td style="color:var(--ink);font-weight:600">{{ $team->name }}</td>
                                    <td class="text-dim">{{ $team->members_count }}</td>
                                    <td style="text-align:right;color:var(--ink);font-weight:700;font-variant-numeric:tabular-nums">
                                        {{ number_format($team->points, 0, ',', ' ') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </section>

    <section class="cta-band">
        <div class="container">
            <h2>Votre équipe n'est pas <span class="glow">encore là</span> ?</h2>
            <div class="hero__cta">
                <a href="{{ url('/inscription') }}" class="btn btn--primary">Inscrire mon équipe</a>
            </div>
        </div>
    </section>
</x-layout>
