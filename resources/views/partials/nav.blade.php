<?php
    $links = [
        ['href' => '/', 'label' => 'Accueil'],
        ['href' => '/wiki', 'label' => 'Wiki'],
        ['href' => '/reglement', 'label' => 'Règlement'],
        ['href' => '/classement', 'label' => 'Classement'],
    ];
    if (!empty($admin)) {
        $links[] = ['href' => '/admin', 'label' => 'Admin'];
    }
    $currentPath = '/' . ltrim(request()->path(), '/');
?>
<header class="nav">
    <div class="container nav__inner">
        <a href="{{ url('/') }}">
            @include('partials.brand')
        </a>

        <nav class="nav__links">
            @foreach($links as $l)
                <?php
                    $isActive = $l['href'] === '/' ? $currentPath === '/' : str_starts_with($currentPath, $l['href']);
                ?>
                <a href="{{ url($l['href']) }}" class="nav__link" data-active="{{ $isActive ? 'true' : 'false' }}">
                    {{ $l['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="nav__right">
            <a href="{{ url('/inscription') }}" class="btn btn--primary btn--sm">
                {{ !empty($user) ? 'Mon équipe' : "S'inscrire" }}
            </a>
            <button class="nav__toggle" aria-label="Ouvrir le menu" aria-expanded="false">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" data-icon="open">
                    <line x1="3" y1="7" x2="21" y2="7" />
                    <line x1="3" y1="12" x2="21" y2="12" />
                    <line x1="3" y1="17" x2="21" y2="17" />
                </svg>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" data-icon="close" style="display:none">
                    <line x1="5" y1="5" x2="19" y2="19" />
                    <line x1="19" y1="5" x2="5" y2="19" />
                </svg>
            </button>
        </div>
    </div>
</header>

<div class="nav-drawer">
    <div class="container">
        <nav class="nav__mobile" data-open="false">
            @foreach($links as $l)
                <a href="{{ url($l['href']) }}">{{ $l['label'] }}</a>
            @endforeach
            <a href="{{ url('/inscription') }}" class="btn btn--primary mt-16">
                {{ !empty($user) ? 'Mon équipe' : "S'inscrire" }}
            </a>
        </nav>
    </div>
</div>
