<?php
    $event = config('event.event');
    $user = \App\Support\DiscordSession::user();
    $isAdmin = \App\Support\AdminAccess::isAdmin($user);
    $pageTitle = trim(($title ?? '') . ($title ?? '' ? ' · ' : '') . $event['name']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#08060a">
    <title>{{ $pageTitle ?: $event['name'] . ' — ' . $event['datesLabel'] }}</title>
    <meta name="description" content="{{ $description ?? "Le dernier grand event du serveur Alpha, et ses 6 ans. Une semaine, une Cité, une seule équipe gagnante. Du 5 au 13 septembre 2026 sur NationsGlory Alpha." }}">

    {{-- Active les animations d'apparition uniquement si le JS fonctionne :
         en cas d'erreur, le contenu reste visible au lieu de disparaître. --}}
    <script>document.documentElement.setAttribute("data-js","1")</script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    @include('partials.nav', ['user' => $user, 'admin' => $isAdmin])

    <main>
        {{ $slot }}
    </main>

    @include('partials.footer')

    <script src="{{ asset('js/reveal.js') }}" defer></script>
    <script src="{{ asset('js/nav.js') }}" defer></script>
    <script src="{{ asset('js/countdown.js') }}" defer></script>
    <script src="{{ asset('js/confirm-submit.js') }}" defer></script>
    @stack('scripts')
</body>
</html>
