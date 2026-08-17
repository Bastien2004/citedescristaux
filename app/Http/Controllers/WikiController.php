<?php

namespace App\Http\Controllers;

class WikiController extends Controller
{
    public function __invoke()
    {
        $sections = [
            ['id' => 'concept', 'label' => 'Le concept'],
            ['id' => 'equipes', 'label' => 'Les équipes'],
            ['id' => 'planning', 'label' => 'Le planning'],
            ['id' => 'capitale', 'label' => 'La Capitale'],
            ['id' => 'shop', 'label' => 'Le shop'],
            ['id' => 'monnaie', 'label' => "L'Alpha Coin"],
            ['id' => 'points', 'label' => 'Les points'],
            ['id' => 'events', 'label' => 'Les events'],
            ['id' => 'faq', 'label' => 'FAQ'],
        ];

        return view('pages.wiki', [
            'event' => config('event.event'),
            'planning' => config('event.planning'),
            'shopCategories' => config('event.shopCategories'),
            'sections' => $sections,
        ]);
    }
}
