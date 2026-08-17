<?php
    // Attend : $to (date ISO), $label, éventuellement $doneLabel
    $doneLabel = $doneLabel ?? "C'est parti !";
?>
<div class="countdown" data-to="{{ $to }}" data-label="{{ $label }}" data-done-label="{{ $doneLabel }}">
    <span class="countdown__label">{{ $label }}</span>
    <div class="countdown__grid">
        <div class="countdown__cell"><div class="countdown__num">—</div><div class="countdown__unit">jours</div></div>
        <div class="countdown__cell"><div class="countdown__num">—</div><div class="countdown__unit">heures</div></div>
        <div class="countdown__cell"><div class="countdown__num">—</div><div class="countdown__unit">minutes</div></div>
        <div class="countdown__cell"><div class="countdown__num">—</div><div class="countdown__unit">secondes</div></div>
    </div>
</div>
