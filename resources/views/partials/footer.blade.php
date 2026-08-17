<?php $event = config('event.event'); ?>
<footer class="footer">
    <div class="container">
        <div class="footer__grid">
            <div class="footer__col">
                <div style="margin-bottom:16px">
                    @include('partials.brand')
                </div>
                <p class="text-muted text-sm" style="max-width:42ch;margin:0">
                    Le dernier grand event du serveur Alpha, et la célébration de ses 6 ans.
                    {{ $event['datesLabel'] }} sur {{ $event['server'] }}.
                </p>
            </div>

            <div class="footer__col">
                <h4>Le site</h4>
                <a href="{{ url('/') }}">Accueil</a>
                <a href="{{ url('/wiki') }}">Wiki</a>
                <a href="{{ url('/reglement') }}">Règlement</a>
                <a href="{{ url('/classement') }}">Classement</a>
                <a href="{{ url('/inscription') }}">Inscription</a>
                @if($event['discordInvite'])
                    <a href="{{ $event['discordInvite'] }}" target="_blank" rel="noreferrer">Discord Alpha ↗</a>
                @endif
            </div>

            <div class="footer__col">
                <h4>Le wiki</h4>
                <a href="{{ url('/wiki#concept') }}">Le concept</a>
                <a href="{{ url('/wiki#equipes') }}">Les équipes</a>
                <a href="{{ url('/wiki#planning') }}">Le planning</a>
                <a href="{{ url('/wiki#shop') }}">Le shop</a>
                <a href="{{ url('/wiki#monnaie') }}">L'Alpha Coin</a>
            </div>
        </div>

        <div class="footer__bottom">
            <span>Organisé par {{ $event['organizer'] }}.</span>
            <span>{{ $event['name'] }} — {{ $event['datesLabel'] }}</span>
        </div>
    </div>
</footer>
