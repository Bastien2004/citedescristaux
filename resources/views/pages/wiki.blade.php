<x-layout title="Wiki" description="Tout comprendre à la Cité des Cristaux : concept, équipes, planning, Capitale, shop, Alpha Coin et système de points.">

    @include('partials.page-header', [
        'kicker' => 'Wiki',
        'title' => 'Tout savoir sur',
        'accent' => 'la Cité',
        'lead' => "Le fonctionnement complet de l'event, section par section. Si une question reste sans réponse, le staff est joignable sur le Discord Alpha.",
    ])

    <section class="section">
        <div class="container">
            <div class="wiki">
                {{-- Sommaire --}}
                <nav class="wiki__nav" aria-label="Sommaire du wiki">
                    @foreach($sections as $s)
                        <a href="#{{ $s['id'] }}">{{ $s['label'] }}</a>
                    @endforeach
                </nav>

                <div class="wiki__body">
                    {{-- ---------------- CONCEPT ---------------- --}}
                    <section class="wiki__section" id="concept">
                        <span class="kicker">Section 01</span>
                        <h2 class="mt-16">Le concept</h2>
                        <p>
                            La <strong>Cité des Cristaux — Alpha Games</strong> est un event compétitif en
                            équipes qui se déroule sur une semaine complète, du 5 au 13
                            septembre 2026, sur le serveur {{ $event['server'] }}. C'est le
                            dernier grand event du Alpha, et il célèbre en même temps ses six
                            ans d'existence.
                        </p>
                        <p>
                            Le principe est simple : des équipes de 6 joueurs s'installent dans une Cité
                            au sein du Alpha et ont une semaine pour accumuler un maximum de points.
                            Tout ce que vous faites compte — farmer, vendre, participer aux events du soir, relever des défis, construire.
                        </p>

                        <h3>Ce qui rend la Cité différente</h3>
                        <ul>
                            <li><strong>Une économie qui bouge en permanence.</strong> Le shop se
                                réinitialise chaque nuit à minuit : les items disponibles et leurs
                                prix changent. Une stratégie de farm rentable aujourd'hui peut
                                devenir inutile demain.</li>
                            <li><strong>Un event chaque soir.</strong> Il y a un rendez-vous par
                                soirée pendant toute la semaine, du mini-jeu au Bingo final.</li>
                            <li><strong>Des défis disponibles 24h/24.</strong> Chasse aux têtes,
                                parkours, défis cachés dans la Capitale : il y a toujours des
                                points à aller chercher, quelle que soit l'heure.</li>
                            <li><strong>Des mondes qui s'ouvrent en cours de route.</strong> Le
                                Nether le mardi, la Lune le jeudi — chacun avec son propre shop.</li>
                        </ul>

                        <div class="note">
                            <p>L'event est diffusé en live pour la cérémonie d'ouverture
                            (samedi 5) et la cérémonie de clôture (samedi 12).</p>
                        </div>
                    </section>

                    {{-- ---------------- ÉQUIPES ---------------- --}}
                    <section class="wiki__section" id="equipes">
                        <span class="kicker">Section 02</span>
                        <h2 class="mt-16">Les équipes</h2>
                        <p>
                            Chaque équipe est composée de <strong>{{ $event['teamSize'] }} joueurs
                            titulaires</strong> et peut compter jusqu'à
                            <strong>{{ $event['substitutes'] }} remplaçants</strong>. Le nombre total
                            d'équipes participantes dépendra du nombre d'inscriptions
                            reçues.
                        </p>

                        <h3>Le chef d'équipe</h3>
                        <p>
                            Chaque équipe désigne un chef au moment de l'inscription.
                            C'est lui qui inscrit l'équipe sur ce site avec son compte
                            Discord. Son rôle pendant l'event :
                        </p>
                        <ul>
                            <li>Il est le <strong>porte-parole</strong> du groupe auprès du staff.</li>
                            <li>Il reçoit <strong>l'item du home base</strong> au début de
                                l'event et choisit où poser le QG de l'équipe.</li>
                            <li>Il est le point de contact en cas de litige ou de question sur le
                                règlement.</li>
                        </ul>

                        <h3>La home base</h3>
                        <p>
                            La home base est le QG de votre équipe pour toute la semaine.
                            Elle est définie par le chef d'équipe en début d'event à
                            l'aide de l'item qui lui est remis. C'est votre point
                            de retour, votre zone de stockage et votre base de départ pour tous
                            vos déplacements.
                        </p>

                        <h3>Le tchat d'équipe</h3>
                        <p>
                            Chaque équipe dispose d'un tchat privé en jeu.
                            Il vous permet de vous coordonner sans que les autres équipes puissent lire vos échanges.
                        </p>

                        <div class="note">
                            <p>Les remplaçants sont facultatifs mais fortement recommandés : sur
                            une semaine complète, il est rare que six joueurs soient
                            disponibles en permanence.</p>
                        </div>
                    </section>

                    {{-- ---------------- PLANNING ---------------- --}}
                    <section class="wiki__section" id="planning">
                        <span class="kicker">Section 03</span>
                        <h2 class="mt-16">Le planning</h2>
                        <p>
                            Neuf jours, neuf temps forts. Les horaires précis des events du soir
                            sont annoncés sur le Discord au fil de la semaine.
                        </p>

                        <div class="table-wrap">
                            <table>
                                <thead>
                                    <tr><th>Jour</th><th>Moment</th><th>Ce qui se passe</th></tr>
                                </thead>
                                <tbody>
                                    @foreach($planning as $d)
                                        <tr>
                                            <td style="white-space:nowrap;color:var(--ink)">
                                                {{ $d['weekday'] }}<br>
                                                <span class="text-sm text-dim">{{ $d['date'] }}</span>
                                            </td>
                                            <td style="white-space:nowrap">{{ $d['time'] }}</td>
                                            <td>
                                                <strong>{{ $d['title'] }}</strong><br>
                                                <span class="text-sm">{{ $d['description'] }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <h3>Les deux cérémonies</h3>
                        <p>
                            La <strong>cérémonie d'ouverture</strong> (samedi 5 septembre à
                            20h45) est diffusée en live. On y présente les règles, les équipes et
                            le planning de la semaine — puis la Cité ouvre dans la foulée.
                        </p>
                        <p>
                            La <strong>cérémonie de clôture</strong> (samedi 12 septembre) sera un récapitulatif de la semaine de farm.
                            Les scores finaux ne sont pas annoncés ce soir-là :
                            ils tombent le lendemain, dimanche 13, lors de l'annonce officielle à l'ONU.
                        </p>
                    </section>

                    {{-- ---------------- CAPITALE ---------------- --}}
                    <section class="wiki__section" id="capitale">
                        <span class="kicker">Section 04</span>
                        <h2 class="mt-16">La Capitale</h2>
                        <h3>Ce qu'on y trouve</h3>
                        <ul>
                            <li>Des parkours — répétables, ils rapportent des cristaux à chaque réussite.
                                Une chasse aux têtes — des têtes sont cachées dans la ville en échange de cristaux </li>
                            <li><strong>Des défis à découvrir sur place</strong> — tout n'est
                                pas annoncé à l'avance, il faut explorer.</li>
                        </ul>
                    </section>

                    {{-- ---------------- SHOP ---------------- --}}
                    <section class="wiki__section" id="shop">
                        <span class="kicker">Section 05</span>
                        <h2 class="mt-16">Le shop</h2>
                        <p>
                            Le shop est le cœur de l'économie de la Cité.
                            C'est là que vous vendez votre farm contre des Cristaux.
                        </p>

                        <h3>Le reset de minuit</h3>
                        <p>
                            Chaque jour à <strong>00:00</strong>, les catalogues sont
                            réinitialisés : de nouveaux items apparaissent, et les prix changent.
                            Ce qui rapportait gros hier peut ne plus rien valoir aujourd'hui.
                        </p>

                        <h3>Comment optimiser</h3>
                        <p>Trois variables à croiser en permanence pour savoir quoi farmer :</p>
                        <ul>
                            <li><strong>Le prix du jour</strong> — combien l'item rapporte aujourd'hui.</li>
                            <li><strong>La quantité obtenable</strong> — un item bon marché mais
                                farmable en masse peut battre un item rare.</li>
                            <li><strong>Le temps d'obtention</strong> — le vrai coût, c'est
                                le temps de vos joueurs.</li>
                        </ul>

                        <div class="note">
                            <p>Prenez l'habitude de consulter le shop dès minuit passé : les
                            équipes qui repèrent les bons items en premier prennent une avance
                            difficile à rattraper.</p>
                        </div>
                    </section>

                    {{-- ---------------- MONNAIE ---------------- --}}
                    <section class="wiki__section" id="monnaie">
                        <span class="kicker">Section 06</span>
                        <h2 class="mt-16">Les Cristaux</h2>
                        <p>
                            Les Cristaux sont la monnaie de la Cité. Vous en gagnez en vendant au shop, et vous pouvez en faire deux choses :
                        </p>
                        <ul>
                            <li><strong>Les déposer en banque</strong> — ils sont alors convertis en
                                points pour votre équipe. C'est ce qui fait monter votre score.</li>
                            <li>Les dépenser — poudre d'os, machines et plus encore. Tout ce qui vous rend plus efficace pour la suite.</li>
                        </ul>

                        <h3>La stratégie du dépôt</h3>
                        <p>
                            Rien ne vous oblige à déposer vos cristaux au fur et à mesure.
                            Certaines équipes préfèrent tout stocker et ne déposer qu'en toute fin d'event,
                            pour masquer leur score réel jusqu'au bout et éviter d'attirer l'attention.
                        </p>

                        <div class="note note--gold">
                            <p>Attention : tant que vos cristaux ne sont pas déposés,
                                ils ne comptent pas dans votre score.
                                Garder tout sous le coude est un pari — assurez-vous de ne pas rater la fenêtre de dépôt.</p>
                        </div>
                    </section>

                    {{-- ---------------- POINTS ---------------- --}}
                    <section class="wiki__section" id="points">
                        <span class="kicker">Section 07</span>
                        <h2 class="mt-16">Les points</h2>
                        <p>
                            Le classement final se joue sur un total de points par équipe. Les
                            points s'obtiennent de plusieurs manières, en parallèle :
                        </p>

                        <div class="table-wrap">
                            <table>
                                <thead><tr><th>Source</th><th>Comment ça marche</th></tr></thead>
                                <tbody>
                                    <tr>
                                        <td style="color:var(--ink);white-space:nowrap">Dépôts en banque</td>
                                        <td>Les Alpha Coins déposés sont convertis en points. C'est
                                            la source principale et la plus régulière.</td>
                                    </tr>
                                    <tr>
                                        <td style="color:var(--ink);white-space:nowrap">Events du soir</td>
                                        <td>Chaque event rapporte des points selon le classement de votre
                                            équipe sur l'épreuve.</td>
                                    </tr>
                                    <tr>
                                        <td style="color:var(--ink);white-space:nowrap">Défis en continu</td>
                                        <td>Parkours, chasse aux têtes et défis de la Capitale, disponibles
                                            24h/24.</td>
                                    </tr>
                                    <tr>
                                        <td style="color:var(--ink);white-space:nowrap">Le Bingo final</td>
                                        <td>L'event du vendredi 11, où tous les points sont en jeu. Il
                                            peut renverser le classement.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <p>
                            Les points dépensés (accès à la Capitale, bâtiment d'équipe,
                            améliorations) sont <strong>déduits de votre score</strong>. Chaque
                            achat est donc un pari sur le fait qu'il vous en rapportera plus
                            qu'il ne vous en coûte.
                        </p>

                        <h3>Le suivi du classement</h3>
                        <p>
                            Un point d'étape est fait <strong>à l'ONU</strong> le
                            dimanche 6 septembre au soir. Les scores finaux sont annoncés le
                            dimanche 13 septembre, également à l'ONU.
                        </p>
                    </section>

                    {{-- ---------------- EVENTS ---------------- --}}
                    <section class="wiki__section" id="events">
                        <span class="kicker">Section 08</span>
                        <h2 class="mt-16">Les events du soir</h2>
                        <p>
                            Il y a un rendez-vous chaque soir de la semaine. Certains sont annoncés
                            à l'avance, d'autres pas du tout.
                        </p>

                        <h3>Le dé à coudre — lundi 7</h3>
                        <p>
                            Le mini-jeu du soir, à ne pas manquer. Les règles précises sont
                            expliquées juste avant le lancement.
                        </p>

                        <h3>Les events mystère — dimanche 6 et mercredi 9</h3>
                        <p>
                            Deux soirées dont le contenu est gardé secret. Le dimanche, l'event
                            est révélé après le point sur les scores à l'ONU. Le mercredi, il
                            n'est annoncé qu'<strong>une heure avant</strong> son
                            lancement — de quoi empêcher toute préparation.
                        </p>

                        <h3>Les ouvertures de mondes — mardi 8 et jeudi 10</h3>
                        <p>
                            Ce ne sont pas des events à proprement parler, mais deux moments qui
                            changent la donne. Le <strong>Nether</strong> ouvre le mardi, la
                            <strong>Lune</strong> le jeudi, chacun avec son shop dédié et ses
                            ressources propres. Les équipes qui s'y adaptent vite prennent
                            l'avantage.
                        </p>

                        <h3>Le Bingo — vendredi 11</h3>
                        <p>
                            L'event final de la semaine, et le plus important :
                            <strong>tous les points sont en jeu</strong>. Une équipe en retard peut
                            encore tout renverser, une équipe en tête peut tout perdre. C'est
                            le moment décisif de la Cité des Cristaux.
                        </p>
                    </section>

                    {{-- ---------------- FAQ ---------------- --}}
                    <section class="wiki__section" id="faq">
                        <span class="kicker">Section 09</span>
                        <h2 class="mt-16">Questions fréquentes</h2>

                        <h3>Faut-il être 6 pour s'inscrire ?</h3>
                        <p>
                            Oui, les {{ $event['teamSize'] }} titulaires sont obligatoires au moment de
                            l'inscription. Les {{ $event['substitutes'] }} remplaçants sont
                            facultatifs mais vivement conseillés.
                        </p>

                        <h3>Puis-je changer un joueur après l'inscription ?</h3>
                        <p>
                            Pas depuis le site. Contactez le staff sur le Discord Alpha : ils
                            peuvent modifier votre équipe tant que les inscriptions ne sont pas
                            closes.
                        </p>

                        <h3>Pourquoi la connexion Discord est-elle obligatoire ?</h3>
                        <p>
                            Pour éviter les fausses inscriptions et pouvoir vous contacter
                            facilement pendant la semaine. Le site récupère uniquement votre
                            identifiant, votre pseudo et votre avatar — rien d'autre.
                        </p>

                        <h3>Que se passe-t-il si un joueur ne peut pas jouer un soir ?</h3>
                        <p>
                            C'est exactement le rôle des remplaçants. Prévenez le staff si un
                            changement doit être fait en cours de semaine.
                        </p>

                        <h3>Est-ce que je peux jouer dans deux équipes ?</h3>
                        <p>
                            Non. Un joueur ne peut appartenir qu'à une seule équipe pour toute
                            la durée de l'event.
                        </p>

                        <h3>Où voir mon score ?</h3>
                        <p>
                            Sur la page <a href="{{ url('/classement') }}" style="color:var(--red-2)">classement</a>,
                            mise à jour par le staff au fil de la semaine, ainsi qu'aux
                            points d'étape à l'ONU.
                        </p>

                        <div class="note">
                            <p>Une question qui n'est pas ici ? Posez-la sur le Discord Alpha,
                            le staff vous répondra — et la réponse finira probablement dans cette
                            FAQ.</p>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="cta-band">
        <div class="container">
            <h2>Prêt à <span class="glow">jouer</span> ?</h2>
            <div class="hero__cta">
                <a href="{{ url('/inscription') }}" class="btn btn--primary">Inscrire mon équipe</a>
                <a href="{{ url('/reglement') }}" class="btn btn--ghost">Lire le règlement</a>
            </div>
        </div>
    </section>
</x-layout>
