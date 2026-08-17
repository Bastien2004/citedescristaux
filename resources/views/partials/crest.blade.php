<?php
    $event = config('event.event');
    $size = $size ?? null;
    $extraClass = $class ?? '';
    $style = $size ? "width:{$size}px;height:auto" : '';
?>
@if($event['logo'])
    <img src="{{ $event['logo'] }}" alt="" aria-hidden="true" @if($style) style="{{ $style }}" @endif class="{{ $extraClass }}">
@else
    <svg viewBox="0 0 64 74" class="crest {{ $extraClass }}" @if($style) style="{{ $style }}" @endif aria-hidden="true" focusable="false">
        <path fill-rule="evenodd" clip-rule="evenodd" fill="currentColor"
              d="M7 3 L57 3 L57 26 L52.5 30 L57 34 L57 45 C57 55.5 46 63.5 32 71.5
                 C18 63.5 7 55.5 7 45 L7 36 L11.5 32 L7 28 Z
                 M32 16 L46.5 31 L32 57.5 L17.5 31 Z
                 M32 16 L46.5 31 L17.5 31 Z
                 M25 35 L32 51 L39 35 Z" />
    </svg>
@endif
