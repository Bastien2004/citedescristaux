<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function __invoke()
    {
        return view('pages.home', [
            'event' => config('event.event'),
            'planning' => config('event.planning'),
            'pillars' => config('event.pillars'),
            'shopCategories' => config('event.shopCategories'),
            'stats' => config('event.stats'),
        ]);
    }
}
