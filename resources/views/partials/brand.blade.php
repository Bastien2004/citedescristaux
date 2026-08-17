<?php $event = config('event.event'); ?>
<span class="brand">
    @include('partials.crest', ['size' => 30])
    <span class="brand__text">
        <span class="brand__over">{{ $event['nameOver'] }}</span>
        <span class="brand__main">{{ $event['nameMain'] }}</span>
    </span>
</span>
