<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Support\Facades\DB;

class ClassementController extends Controller
{
    public function __invoke()
    {
        $event = config('event.event');
        $teams = collect();
        $dbError = false;

        try {
            $teams = Team::query()
                ->where('status', 'VALIDATED')
                ->withCount('members')
                ->orderByDesc('points')
                ->orderBy('name')
                ->get();
        } catch (\Throwable $e) {
            report($e);
            $dbError = true;
        }

        $started = now()->greaterThanOrEqualTo($event['openingLive']);

        return view('pages.classement', [
            'event' => $event,
            'teams' => $teams,
            'dbError' => $dbError,
            'started' => $started,
        ]);
    }
}
