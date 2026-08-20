<x-layout>
    <?php
        $icons = [
            'eco' => '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 17 L9 11 L13 14 L21 6" /><path d="M15 6 H21 V12" /></svg>',
            'events' => '<svg width="26" height="26" viewBox="0 0 24 24" fill="currentColor"><path d="M20 15.5A8.5 8.5 0 0 1 8.5 4 8.5 8.5 0 1 0 20 15.5Z" /></svg>',
            'defis' => '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 3 V21" /><path d="M5 4 H18 L15 8 L18 12 H5" /></svg>',
        ];
    ?>

    {{-- ---------------- HERO ---------------- --}}
    <section class="hero">
        <div class="wine-bg"></div>
        @include('partials.frame')
        <div class="container hero__inner">
            @include('partials.crest', ['class' => 'hero__crest'])

            <p class="hero__over">{{ $event['nameOver'] }}</p>
            <h1 class="hero__title">{{ $event['nameMain'] }}</h1>
            <p class="hero__dates">{{ $event['datesShort'] }}</p>

            <p class="hero__tagline">{{ $event['tagline'] }}</p>
            <p class="hero__meta">{{ $event['years'] }} · {{ $event['server'] }}</p>

            <div class="hero__cta">
                <a href="{{ url('/inscription') }}" class="btn btn--primary">Inscrire mon équipe</a>
                <a href="#concept" class="btn btn--ghost">Découvrir l'event</a>
            </div>

            @include('partials.countdown', [
                'to' => $event['openingLive'],
                'label' => 'Ouverture de la Cité dans',
                'doneLabel' => 'La Cité est ouverte',
            ])
        </div>
    </section>

    {{-- ---------------- MANIFESTE ---------------- --}}
    <section class="section section--tight">
        <div class="container">
            <div class="reveal text-center">
                <h2 class="display" style="font-size:clamp(30px, 4.6vw, 60px);line-height:1.06">
                    Six ans d'Alpha.<br>
                    <span class="glow">Un dernier grand chapitre.</span>
                </h2>
                <p class="lead" style="margin:26px auto 0;text-align:center">
                    La Cité des Cristaux, c'est neuf jours pour écrire la fin de
                    l'histoire. Une ville à faire vivre, une économie à dompter, des
                    events chaque soir — et une seule équipe qui restera dans les
                    mémoires.
                </p>
            </div>
        </div>
    </section>

    {{-- ---------------- STATS ---------------- --}}
    <div class="container">
        <div class="stats reveal">
            @foreach($stats as $s)
                <div class="stats__item">
                    <div class="stats__value">{{ $s['value'] }}</div>
                    <div class="stats__label">{{ $s['label'] }}</div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- ---------------- CONCEPT ---------------- --}}
    <section class="section" id="concept">
        <div class="container">
            <div class="section-head section-head--center reveal">
                <span class="kicker kicker--center">01 — Le concept</span>
                <h2>Trois moteurs,<br>toute la semaine</h2>
                <p class="lead">
                    Une cité spéciale Alpha en équipes de {{ $event['teamSize'] }} joueurs, pendant une
                    semaine complète. Tout ce que vous faites rapporte des points.
                </p>
            </div>

            <div class="grid-3">
                @foreach($pillars as $i => $p)
                    <article class="card reveal" data-delay="{{ $i * 110 }}">
                        <div class="card__icon">{!! $icons[$p['key']] !!}</div>
                        <div class="card__num">0{{ $i + 1 }}</div>
                        <h3 class="card__title">{{ $p['title'] }}</h3>
                        <div class="card__lead">{{ $p['lead'] }}</div>
                        <p class="card__text">{{ $p['description'] }}</p>
                    </article>
                @endforeach
            </div>

            <div class="text-center mt-48 reveal">
                <span class="pill pill--red">Tout rapporte des points</span>
            </div>
        </div>
    </section>

    {{-- ---------------- ÉQUIPES ---------------- --}}
    <section class="section" style="background:rgba(255,255,255,.012)">
        <div class="container">
            <div class="split">
                <div class="reveal">
                    <span class="kicker">02 — Les équipes</span>
                    <h2 class="display" style="font-size:clamp(30px, 4.4vw, 52px);margin:18px 0 0">
                        6 joueurs.<br>
                        <span class="glow">+2 remplaçants.</span>
                    </h2>
                    <p class="lead mt-24">
                        Chaque équipe choisit son nom et désigne un chef. Le nombre
                        d'équipes dépendra des inscriptions — à vous de monter la vôtre
                        avant la fermeture.
                    </p>
                    <ul class="checklist">
                        <li><span class="bullet"></span><span><strong>Un chef d'équipe</strong> — porte-parole du groupe.</span></li>
                        <li><span class="bullet"></span><span><strong>Un home base</strong> — définie par le chef, c'est le QG de l'équipe pour toute la semaine.</span></li>
                        <li><span class="bullet"></span><span><strong>Un groupe dédié</strong> — un tchat privé pour se coordonner.</span></li>
                    </ul>
                    <div class="row mt-32">
                        <a href="{{ url('/inscription') }}" class="btn btn--primary">Monter mon équipe</a>
                        <a href="{{ url('/wiki#equipes') }}" class="btn btn--ghost">En savoir plus</a>
                    </div>
                </div>

                <div class="split__visual reveal" data-delay="120">
                    <div style="display:grid;grid-template-columns:repeat(3, 1fr);gap:16px">
                        @for($i = 0; $i < 6; $i++)
                            <div style="aspect-ratio:1;border-radius:18px;background:linear-gradient(180deg, rgba(255,45,70,.16), rgba(158,31,47,.1));border:1px solid rgba(255,45,70,.3);display:grid;place-items:center;color:var(--red-2);box-shadow:0 10px 30px rgba(0,0,0,.4)">
                                <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><circle cx="12" cy="8" r="4" /><path d="M4 21c0-4 3.6-6.5 8-6.5s8 2.5 8 6.5" /></svg>
                            </div>
                        @endfor
                        @for($i = 0; $i < 2; $i++)
                            <div style="aspect-ratio:1;border-radius:18px;border:2px dashed rgba(255,255,255,.16);display:grid;place-items:center;color:var(--dim)">
                                <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><circle cx="12" cy="8" r="4" /><path d="M4 21c0-4 3.6-6.5 8-6.5s8 2.5 8 6.5" /></svg>
                            </div>
                        @endfor
                        <div style="display:grid;place-items:center;font-family:var(--font-label);font-weight:700;font-size:14px;letter-spacing:.14em;text-transform:uppercase;color:var(--dim);text-align:center">
                            Remplaçants
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ---------------- PLANNING ---------------- --}}
    <section class="section" id="planning">
        <div class="container">
            <div class="section-head section-head--center reveal">
                <span class="kicker kicker--center">03 — Le planning</span>
                <h2>Neuf jours,<br><span class="glow">neuf temps forts</span></h2>
                <p class="lead">
                    Cérémonie d'ouverture et fermeture en live, Event exclusif clôturés par le Bingo
                </p>
            </div>

            <div class="planning">
                @foreach($planning as $i => $day)
                    <div class="day reveal{{ !empty($day['gold']) ? ' day--gold' : '' }}" data-delay="{{ ($i % 3) * 90 }}">
                        <div class="day__head">{{ $day['weekday'] }} {{ $day['date'] }}</div>
                        <div class="day__body">
                            <div class="day__wm">{{ $day['watermark'] }}</div>

                            @if(!empty($day['badge']))
                                <div class="day__badge">
                                    <span class="pill {{ !empty($day['live']) ? 'pill--live' : (!empty($day['gold']) ? 'pill--gold' : 'pill--red') }}">
                                        @if(!empty($day['live']))<span class="dot dot--pulse"></span>@endif
                                        {{ $day['badge'] }}
                                    </span>
                                </div>
                            @endif

                            <div class="day__time">{{ $day['time'] }}</div>
                            <h3 class="day__title">{{ $day['title'] }}</h3>
                            <p class="day__desc">{{ $day['description'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ---------------- CAPITALE ---------------- --}}
    <section class="section" style="background:rgba(255,255,255,.012)">
        <div class="container">
            <div class="split split--reverse">
                <div class="reveal">
                    <span class="kicker">04 — La Capitale</span>
                    <h2 class="display" style="font-size:clamp(30px, 4.4vw, 52px);margin:18px 0 0">
                        Au-dessus<br>de la <span class="glow">brume</span>
                    </h2>
                    <p class="lead mt-24">
                        Une Capitale en hauteur, c'est le cœur social et compétitif de la Cité : on y monte pour jouer, pour se montrer, et pour bâtir.
                    </p>
                    <ul class="checklist">
                        <li><span class="bullet"></span><span>Des parkours à répéter pour grappiller des points</span></li>
                        <li><span class="bullet"></span><span>Une chasse aux têtes ouverte en permanence</span></li>
                    </ul>
                </div>

                <div class="split__visual reveal" data-delay="120">
                    @include('partials.capitale-visual')
                </div>
            </div>
        </div>
    </section>

    {{-- ---------------- SHOP ---------------- --}}
    <section class="section" id="shop">
        <div class="container">
            <div class="section-head section-head--center reveal">
                <span class="kicker kicker--center">05 — Le shop</span>
                <h2>Chaque nuit,<br><span class="glow">tout change</span></h2>
            </div>

            <div class="reveal">
                <div class="clock">00:00</div>
                <p class="lead text-center" style="margin:22px auto 0">
                    À minuit pile, les catalogues sont réinitialisés : nouveaux items,
                    nouveaux prix. Les catégories, elles, ne changent jamais. À vous de
                    repérer chaque jour ce qui rapporte vraiment.
                </p>
            </div>



            <div class="grid-3 mt-48">
                <?php
                    $shopCards = [
                        ['t' => 'Quantité', 'd' => 'Un item peu cher mais farmable en masse peut battre un item rare.'],
                        ['t' => 'Rapidité', 'd' => "Le temps d'obtention compte autant que le prix affiché."],
                        ['t' => 'Prix du jour', 'd' => "Ce qui était rentable hier ne l'est plus forcément aujourd'hui."],
                    ];
                ?>
                @foreach($shopCards as $i => $x)
                    <article class="card reveal" data-delay="{{ $i * 110 }}">
                        <h3 class="card__title" style="font-size:24px;margin-top:0">{{ $x['t'] }}</h3>
                        <p class="card__text">{{ $x['d'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ---------------- MONNAIE ---------------- --}}
    <section class="section" style="background:rgba(255,255,255,.012)">
        <div class="container">
            <div class="split">
                <div class="reveal">
                    <span class="kicker">06 — La monnaie</span>
                    <h2 class="display" style="font-size:clamp(30px, 4.4vw, 52px);margin:18px 0 0">
                        Les <span class="glow-gold">Cristaux</span>
                    </h2>
                    <p class="lead mt-24">
                        La monnaie de la Cité. Déposez vos cristaux en
                        banque pour transformer votre farm en points,
                        ou dépensez-les pour vous équiper — poudre d'os,
                        machines et plus encore !
                    </p>
                    <div class="note note--gold">
                        <p><strong>Stratégie :</strong> rien ne vous oblige à déposer au fur et
                        à mesure. Vous pouvez tout stocker et ne déposer qu'en fin
                        d'event pour cacher votre score… au risque de tout perdre.</p>
                    </div>
                </div>

                <div class="split__visual reveal" data-delay="120">
                    @if($event['coinImage'] ?? false)
                        <div class="coin coin--image" style="--coin-img:url('{{ asset($event['coinImage']) }}')"></div>
                    @else
                        <div class="coin">A</div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- ---------------- CTA FINAL ---------------- --}}
    <section class="cta-band">
        <div class="wine-bg" style="transform:scaleY(-1)"></div>
        @include('partials.frame')
        <div class="container">
            <div class="reveal">
                <span class="pill pill--gold">Inscriptions</span>
                <h2 class="mt-24">Rejoignez<br>la <span class="glow">Cité</span></h2>
                <p class="lead text-center" style="margin:24px auto 0">
                    Connectez-vous avec Discord, réunissez vos {{ $event['teamSize'] }} joueurs et
                    inscrivez votre équipe avant la fermeture.
                </p>
                <div class="hero__cta">
                    <a href="{{ url('/inscription') }}" class="btn btn--primary">Inscrire mon équipe</a>
                    <a href="{{ url('/reglement') }}" class="btn btn--ghost">Lire le règlement</a>
                </div>
                <div style="margin-top:12px">
                    @include('partials.countdown', [
                        'to' => $event['registrationClose'],
                        'label' => 'Fermeture des inscriptions dans',
                        'doneLabel' => 'Les inscriptions sont fermées',
                    ])
                </div>
            </div>
        </div>
    </section>
</x-layout>
