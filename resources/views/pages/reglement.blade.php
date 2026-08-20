<x-layout title="Règlement" description="Le règlement complet de la Cité des Cristaux — Alpha Games : inscription, déroulement, fair-play, triche, points, sanctions.">

    @include('partials.page-header', [
        'kicker' => 'Règlement',
        'title' => 'Les règles de',
        'accent' => 'la Cité',
        'lead' => "À lire avant de s'inscrire. Les décisions du staff pendant l'event s'appuient sur ce règlement.",
    ])

    <section class="section">
        <div class="container">
            <div class="wiki">
                {{-- Sommaire --}}
                <nav class="wiki__nav" aria-label="Sommaire du règlement">
                    @foreach($articles as $article)
                        <a href="#{{ \Illuminate\Support\Str::slug($article['title']) }}">{{ $article['title'] }}</a>
                    @endforeach
                </nav>

                <div class="wiki__body">
                    @foreach($articles as $i => $article)
                        <section class="wiki__section" id="{{ \Illuminate\Support\Str::slug($article['title']) }}">
                            <span class="kicker">Article {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            <h2 class="mt-16">{{ $article['title'] }}</h2>
                            <ol>
                                @foreach($article['rules'] as $rule)
                                    <li>{{ $rule }}</li>
                                @endforeach
                            </ol>
                        </section>
                    @endforeach
                </div>
            </div>

            <div class="note note--gold mt-48">
                <p>
                    En vous inscrivant à la {{ $event['name'] }}, vous
                    reconnaissez avoir pris connaissance de ce règlement et vous engagez
                    à le respecter, ainsi que votre équipe.
                </p>
            </div>
        </div>
    </section>

    <section class="cta-band">
        <div class="container">
            <h2>Prêt à <span class="glow">vous engager</span> ?</h2>
            <div class="hero__cta">
                <a href="{{ url('/inscription') }}" class="btn btn--primary">Inscrire mon équipe</a>
                <a href="{{ url('/wiki') }}" class="btn btn--ghost">Consulter le wiki</a>
            </div>
        </div>
    </section>
</x-layout>
