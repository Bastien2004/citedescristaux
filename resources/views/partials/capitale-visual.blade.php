<?php
    $event = config('event.event');
    $islands = [
        [
            'left' => '8%', 'top' => '40%', 'width' => '40%', 'height' => '3.5%',
            'towers' => [
                ['left' => '14%', 'width' => '17%', 'height' => '58%'],
                ['left' => '36%', 'width' => '13%', 'height' => '40%'],
                ['left' => '55%', 'width' => '20%', 'height' => '72%'],
                ['left' => '80%', 'width' => '11%', 'height' => '32%'],
            ],
        ],
        [
            'left' => '54%', 'top' => '55%', 'width' => '34%', 'height' => '3%',
            'towers' => [
                ['left' => '10%', 'width' => '18%', 'height' => '48%'],
                ['left' => '34%', 'width' => '14%', 'height' => '68%'],
                ['left' => '56%', 'width' => '22%', 'height' => '36%'],
            ],
        ],
        [
            'left' => '34%', 'top' => '72%', 'width' => '22%', 'height' => '2.4%',
            'towers' => [
                ['left' => '30%', 'width' => '24%', 'height' => '30%'],
            ],
        ],
    ];
?>
@if($event['capitaleImage'])
    <div class="capitale">
        <img src="{{ $event['capitaleImage'] }}" alt="La Capitale de la Cité des Cristaux">
        <div class="capitale__tag"><span class="pill pill--red">La Capitale</span></div>
    </div>
@else
    <div class="capitale" role="img" aria-label="Illustration de la Capitale, une cité flottante au-dessus de la brume">
        <div class="capitale__stars"></div>
        <div class="capitale__horizon"></div>

        @foreach($islands as $island)
            <div class="capitale__island" style="left:{{ $island['left'] }};top:{{ $island['top'] }};width:{{ $island['width'] }};height:{{ $island['height'] }}">
                @foreach($island['towers'] as $t)
                    <div class="capitale__tower" style="left:{{ $t['left'] }};width:{{ $t['width'] }};height:calc({{ $t['height'] }} * 6);bottom:100%"></div>
                @endforeach
                <div class="capitale__slab"></div>
            </div>
        @endforeach

        <div class="capitale__fog"></div>
        <div class="capitale__tag"><span class="pill pill--red">La Capitale</span></div>
    </div>
@endif
