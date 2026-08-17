<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\TeamMember;
use App\Support\DiscordSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InscriptionController extends Controller
{
    /** Équivalent de src/app/inscription/page.tsx */
    public function show(Request $request)
    {
        $event = config('event.event');
        $user = DiscordSession::user();

        $now = now();
        $opensAt = \Illuminate\Support\Carbon::parse($event['registrationOpen']);
        $closesAt = \Illuminate\Support\Carbon::parse($event['registrationClose']);
        $notYetOpen = $now->lessThan($opensAt);
        $closed = $now->greaterThan($closesAt);

        $team = null;
        $dbError = false;

        if ($user) {
            try {
                $team = Team::with('members')->where('captain_id', $user['id'])->first();
            } catch (\Throwable $e) {
                report($e);
                $dbError = true;
            }
        }

        $errors = [
            'denied' => "Vous avez refusé l'autorisation Discord. Réessayez pour vous inscrire.",
            'state' => 'La session de connexion a expiré. Merci de réessayer.',
            'oauth' => 'La connexion Discord a échoué. Réessayez dans un instant.',
            'config' => "La connexion Discord n'est pas encore configurée sur ce site. Prévenez le staff.",
        ];

        return view('pages.inscription', [
            'event' => $event,
            'user' => $user,
            'notYetOpen' => $notYetOpen,
            'closed' => $closed,
            'team' => $team,
            'dbError' => $dbError,
            'errorMessage' => $errors[$request->query('error')] ?? null,
            'fieldErrors' => session('inscription_field_errors', []),
            'formError' => session('inscription_error'),
            'oldInput' => session('inscription_old', []),
        ]);
    }

    /** Équivalent de src/app/inscription/actions.ts → registerTeam() */
    public function store(Request $request)
    {
        $event = config('event.event');
        $user = DiscordSession::user();

        if (! $user) {
            return back()->with('inscription_error', 'Vous devez être connecté avec Discord pour vous inscrire.');
        }

        if (now()->greaterThan(\Illuminate\Support\Carbon::parse($event['registrationClose']))) {
            return back()->with('inscription_error', 'Les inscriptions sont désormais fermées.');
        }

        $fieldErrors = [];

        // --- Nom d'équipe ---
        $name = trim((string) $request->input('teamName', ''));
        $name = preg_replace('/\s+/', ' ', $name);

        if (mb_strlen($name) < 3 || mb_strlen($name) > 32) {
            $fieldErrors['teamName'] = "Le nom d'équipe doit faire entre 3 et 32 caractères.";
        } elseif (! preg_match('/^[\p{L}\p{N} \'&_.-]+$/u', $name)) {
            $fieldErrors['teamName'] = "Le nom d'équipe contient des caractères non autorisés.";
        }

        $tagRegex = '/^[a-zA-Z0-9._-]{2,32}(#\d{4})?$/';
        $cleanTag = fn ($value) => ltrim(trim((string) $value), '@');

        // --- Titulaires ---
        $titulaires = [];
        for ($i = 0; $i < $event['teamSize']; $i++) {
            $tag = $cleanTag($request->input("player{$i}"));
            if (! $tag) {
                $fieldErrors["player{$i}"] = 'Champ obligatoire.';
            } elseif (! preg_match($tagRegex, $tag)) {
                $fieldErrors["player{$i}"] = 'Pseudo Discord invalide.';
            }
            $titulaires[] = $tag;
        }

        // --- Remplaçants (facultatifs) ---
        $remplacants = [];
        for ($i = 0; $i < $event['substitutes']; $i++) {
            $tag = $cleanTag($request->input("sub{$i}"));
            if ($tag && ! preg_match($tagRegex, $tag)) {
                $fieldErrors["sub{$i}"] = 'Pseudo Discord invalide.';
            }
            $remplacants[] = $tag;
        }

        // --- Doublons ---
        $all = collect(array_merge($titulaires, $remplacants))
            ->filter()
            ->map(fn ($t) => mb_strtolower($t));

        $dupes = $all->duplicates()->unique()->values();

        if ($dupes->isNotEmpty()) {
            return back()
                ->with('inscription_field_errors', $fieldErrors)
                ->with('inscription_error', 'Un même joueur est renseigné plusieurs fois : ' . $dupes->implode(', ') . '.')
                ->with('inscription_old', $request->all());
        }

        if (count($fieldErrors) > 0) {
            return back()
                ->with('inscription_field_errors', $fieldErrors)
                ->with('inscription_error', 'Certains champs sont incomplets ou invalides.')
                ->with('inscription_old', $request->all());
        }

        // --- Écriture ---
        try {
            $existing = Team::where('captain_id', $user['id'])->first();
            if ($existing) {
                return back()->with(
                    'inscription_error',
                    "Vous avez déjà inscrit l'équipe « {$existing->name} ». Contactez le staff sur Discord pour la modifier."
                );
            }

            if (Team::whereRaw('lower(name) = lower(?)', [$name])->exists()) {
                return back()
                    ->with('inscription_field_errors', ['teamName' => "Ce nom d'équipe est déjà pris."])
                    ->with('inscription_error', "Ce nom d'équipe est déjà pris, choisissez-en un autre.")
                    ->with('inscription_old', $request->all());
            }

            DB::transaction(function () use ($name, $user, $titulaires, $remplacants) {
                $team = Team::create([
                    'id' => (string) Str::uuid(),
                    'name' => $name,
                    'captain_id' => $user['id'],
                    'captain_tag' => DiscordSession::displayName($user),
                    'captain_avatar' => $user['avatar'] ?? null,
                ]);

                foreach ($titulaires as $i => $tag) {
                    TeamMember::create([
                        'team_id' => $team->id,
                        'discord_tag' => $tag,
                        'role' => 'TITULAIRE',
                        'position' => $i + 1,
                        'is_captain' => $i === 0,
                    ]);
                }

                foreach (array_values(array_filter($remplacants)) as $i => $tag) {
                    TeamMember::create([
                        'team_id' => $team->id,
                        'discord_tag' => $tag,
                        'role' => 'REMPLACANT',
                        'position' => $i + 1,
                        'is_captain' => false,
                    ]);
                }
            });

            return redirect()->route('inscription')->with('inscription_ok', true);
        } catch (\Throwable $e) {
            report($e);

            return back()->with(
                'inscription_error',
                'Une erreur est survenue lors de l\'enregistrement. Réessayez, et prévenez le staff si le problème persiste.'
            );
        }
    }
}
