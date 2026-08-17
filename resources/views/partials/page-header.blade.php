<?php
    // Attend : $kicker, $title, éventuellement $accent, $lead
    $accent = $accent ?? null;
    $lead = $lead ?? null;
?>
<section class="page-head">
    <div class="wine-bg"></div>
    @include('partials.frame')
    <div class="container">
        <span class="kicker">{{ $kicker }}</span>
        <h1>
            {{ $title }}
            @if($accent)
                <span class="glow">{{ $accent }}</span>
            @endif
        </h1>
        @if($lead)
            <p class="lead" style="margin-top:20px">{{ $lead }}</p>
        @endif
    </div>
</section>
