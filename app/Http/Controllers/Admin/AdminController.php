<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Team;
use App\Models\TeamMember;
use App\Support\AdminAccess;
use App\Support\DiscordSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class AdminController extends Controller
{
    private function requireAdmin(): array
    {
        $user = DiscordSession::user();
        if (! AdminAccess::isAdmin($user)) {
            throw new AccessDeniedHttpException('Accès refusé.');
        }

        return $user;
    }

    /** Équivalent de src/app/admin/page.tsx */
    public function index(Request $request)
    {
        $user = DiscordSession::user();

        if (! $user) {
            return view('pages.admin', ['step' => 'login']);
        }

        if (! AdminAccess::isAdmin($user)) {
            return view('pages.admin', ['step' => 'forbidden', 'user' => $user]);
        }

        $teams = collect();
        $admins = collect();
        $dbError = null;

        try {
            $teams = Team::with('members')->orderByRaw(
                "CASE status WHEN 'PENDING' THEN 0 WHEN 'VALIDATED' THEN 1 ELSE 2 END, created_at ASC"
            )->get();
            $admins = Admin::orderBy('created_at')->get();
        } catch (\Throwable $e) {
            report($e);
            $dbError = $e->getMessage();
        }

        $pending = $teams->where('status', 'PENDING')->values();
        $validated = $teams->where('status', 'VALIDATED')
            ->sortBy([['points', 'desc'], ['name', 'asc']])->values();
        $rejected = $teams->where('status', 'REJECTED')->values();

        $owners = AdminAccess::ownerIds();
        $viewerIsOwner = AdminAccess::isOwner($user);

        $tabs = [
            ['key' => 'candidatures', 'label' => 'Candidatures'],
            ['key' => 'equipes', 'label' => 'Équipes Cité'],
            ['key' => 'admins', 'label' => 'Accès au panel'],
        ];
        $tabKeys = array_column($tabs, 'key');
        $tab = in_array($request->query('tab'), $tabKeys, true) ? $request->query('tab') : 'candidatures';

        $counts = [
            'candidatures' => $pending->count(),
            'equipes' => $validated->count(),
            'admins' => count($owners) + $admins->count(),
        ];

        return view('pages.admin', [
            'step' => 'panel',
            'user' => $user,
            'dbError' => $dbError,
            'pending' => $pending,
            'validated' => $validated,
            'rejected' => $rejected,
            'owners' => $owners,
            'admins' => $admins,
            'viewerIsOwner' => $viewerIsOwner,
            'tabs' => $tabs,
            'tab' => $tab,
            'counts' => $counts,
        ]);
    }

    /* ------------------------------ Équipes ------------------------------ */

    public function acceptTeam(Team $team)
    {
        $this->requireAdmin();
        $team->update(['status' => 'VALIDATED']);

        return back();
    }

    public function rejectTeam(Team $team)
    {
        $this->requireAdmin();
        $team->update(['status' => 'REJECTED']);

        return back();
    }

    public function unlistTeam(Team $team)
    {
        $this->requireAdmin();
        $team->update(['status' => 'PENDING']);

        return back();
    }

    public function setTeamStatus(Team $team, Request $request)
    {
        $this->requireAdmin();
        $status = $request->input('status');

        if (! in_array($status, ['PENDING', 'VALIDATED', 'REJECTED'], true)) {
            return back();
        }

        $team->update(['status' => $status]);

        return back();
    }

    public function setPoints(Team $team, Request $request)
    {
        $this->requireAdmin();
        $points = (int) $request->input('points', 0);
        $team->update(['points' => $points]);

        return back();
    }

    public function deleteTeam(Team $team)
    {
        $this->requireAdmin();
        $team->delete();

        return back();
    }

    public function createTeam(Request $request)
    {
        $this->requireAdmin();

        $name = trim((string) $request->input('name', ''));
        $name = preg_replace('/\s+/', ' ', $name);

        $captainId = trim((string) $request->input('captainId', ''));
        $captainTag = ltrim(trim((string) $request->input('captainTag', '')), '@');

        $idRegex = '/^\d{17,20}$/';
        $tagRegex = '/^[a-zA-Z0-9._-]{2,32}(#\d{4})?$/';

        if (mb_strlen($name) < 3 || mb_strlen($name) > 32) {
            return back()->with('admin_error', "Le nom d'équipe doit faire entre 3 et 32 caractères.");
        }

        if (! preg_match('/^[\p{L}\p{N} \'&_.-]+$/u', $name)) {
            return back()->with('admin_error', "Le nom d'équipe contient des caractères non autorisés.");
        }

        if (! preg_match($idRegex, $captainId)) {
            return back()->with('admin_error', "Identifiant Discord du capitaine invalide (17 à 20 chiffres).");
        }

        if (! $captainTag || ! preg_match($tagRegex, $captainTag)) {
            return back()->with('admin_error', 'Pseudo Discord du capitaine invalide.');
        }

        if (Team::whereRaw('lower(name) = lower(?)', [$name])->exists()) {
            return back()->with('admin_error', "Ce nom d'équipe est déjà pris.");
        }

        if (Team::where('captain_id', $captainId)->exists()) {
            return back()->with('admin_error', 'Ce joueur est déjà capitaine d\'une autre équipe.');
        }

        try {
            DB::transaction(function () use ($name, $captainId, $captainTag) {
                $team = Team::create([
                    'id' => (string) Str::uuid(),
                    'name' => $name,
                    'captain_id' => $captainId,
                    'captain_tag' => $captainTag,
                    'captain_avatar' => null,
                    'status' => 'VALIDATED',
                ]);

                TeamMember::create([
                    'team_id' => $team->id,
                    'discord_id' => $captainId,
                    'discord_tag' => $captainTag,
                    'role' => 'TITULAIRE',
                    'position' => 1,
                    'is_captain' => true,
                ]);
            });

            return back()->with('admin_ok', "Équipe « {$name} » créée. Ajoute les autres membres depuis sa fiche.");
        } catch (\Throwable $e) {
            report($e);

            return back()->with('admin_error', "Une erreur est survenue lors de la création de l'équipe.");
        }
    }

    public function addMember(Team $team, Request $request)
    {
        $this->requireAdmin();

        $event = config('event.event');

        $id = trim((string) $request->input('discordId', ''));
        $tag = ltrim(trim((string) $request->input('discordTag', '')), '@');
        $role = $request->input('role') === 'REMPLACANT' ? 'REMPLACANT' : 'TITULAIRE';

        $idRegex = '/^\d{17,20}$/';
        $tagRegex = '/^[a-zA-Z0-9._-]{2,32}(#\d{4})?$/';

        if (! preg_match($idRegex, $id)) {
            return back()->with('admin_error', "Identifiant Discord invalide (17 à 20 chiffres).");
        }

        if (! preg_match($tagRegex, $tag)) {
            return back()->with('admin_error', 'Pseudo Discord invalide.');
        }

        // Pas de doublon d'ID, y compris avec le capitaine et les autres membres de l'équipe.
        if ($team->members()->where('discord_id', $id)->exists()) {
            return back()->with('admin_error', 'Ce joueur fait déjà partie de cette équipe.');
        }

        $currentTitulaires = $team->members()->where('role', 'TITULAIRE')->count();
        $currentRemplacants = $team->members()->where('role', 'REMPLACANT')->count();

        if ($role === 'TITULAIRE' && $currentTitulaires >= $event['teamSize']) {
            return back()->with('admin_error', "L'équipe a déjà le nombre maximum de titulaires ({$event['teamSize']}).");
        }

        if ($role === 'REMPLACANT' && $currentRemplacants >= $event['substitutes']) {
            return back()->with('admin_error', "L'équipe a déjà le nombre maximum de remplaçants ({$event['substitutes']}).");
        }

        $position = ($role === 'TITULAIRE' ? $currentTitulaires : $currentRemplacants) + 1;

        try {
            TeamMember::create([
                'team_id' => $team->id,
                'discord_id' => $id,
                'discord_tag' => $tag,
                'role' => $role,
                'position' => $position,
                'is_captain' => false,
            ]);

            return back()->with('admin_ok', 'Membre ajouté.');
        } catch (\Throwable $e) {
            report($e);

            return back()->with('admin_error', "Impossible d'ajouter ce membre.");
        }
    }

    public function deleteMember(Team $team, TeamMember $member)
    {
        $this->requireAdmin();

        if ($member->team_id !== $team->id) {
            abort(404);
        }

        if ($member->is_captain) {
            return back()->with('admin_error', "Impossible de supprimer le capitaine. Supprimez l'équipe entière si besoin.");
        }

        $member->delete();

        return back()->with('admin_ok', 'Membre retiré de l\'équipe.');
    }

    /* --------------------------- Édition des équipes --------------------------- */

    public function updateMember(Team $team, TeamMember $member, Request $request)
    {
        $this->requireAdmin();

        if ($member->team_id !== $team->id) {
            abort(404);
        }

        $id = trim((string) $request->input('discordId', ''));
        $tag = ltrim(trim((string) $request->input('discordTag', '')), '@');

        $idRegex = '/^\d{17,20}$/';
        $tagRegex = '/^[a-zA-Z0-9._-]{2,32}(#\d{4})?$/';

        if (! preg_match($idRegex, $id)) {
            return back()->with('admin_error', "Identifiant Discord invalide pour ce membre (17 à 20 chiffres).");
        }

        if (! preg_match($tagRegex, $tag)) {
            return back()->with('admin_error', 'Pseudo Discord invalide pour ce membre.');
        }

        $member->update([
            'discord_id' => $id,
            'discord_tag' => $tag,
        ]);

        // Si on modifie le capitaine, on garde team.captain_tag cohérent (affiché ailleurs sur le site).
        if ($member->is_captain) {
            $team->update(['captain_tag' => $tag]);
        }

        return back()->with('admin_ok', 'Membre mis à jour.');
    }

    public function updateTeamName(Team $team, Request $request)
    {
        $this->requireAdmin();

        $name = trim((string) $request->input('name', ''));
        $name = preg_replace('/\s+/', ' ', $name);

        if (mb_strlen($name) < 3 || mb_strlen($name) > 32) {
            return back()->with('admin_error', "Le nom d'équipe doit faire entre 3 et 32 caractères.");
        }

        if (! preg_match('/^[\p{L}\p{N} \'&_.-]+$/u', $name)) {
            return back()->with('admin_error', "Le nom d'équipe contient des caractères non autorisés.");
        }

        if (Team::whereRaw('lower(name) = lower(?)', [$name])->where('id', '!=', $team->id)->exists()) {
            return back()->with('admin_error', "Ce nom d'équipe est déjà pris par une autre équipe.");
        }

        $team->update(['name' => $name]);

        return back()->with('admin_ok', "Nom de l'équipe mis à jour.");
    }

    /* ---------------------------- Administrateurs ---------------------------- */

    public function addAdmin(Request $request)
    {
        $me = $this->requireAdmin();

        $discordId = trim((string) $request->input('discordId', ''));
        $label = trim((string) $request->input('label', '')) ?: null;

        if (! preg_match('/^\d{17,20}$/', $discordId)) {
            return back()->with('admin_error',
                "Identifiant Discord invalide : c'est une suite de 17 à 20 chiffres (clic droit sur le pseudo → « Copier l'identifiant »)."
            );
        }

        if (in_array($discordId, AdminAccess::ownerIds(), true)) {
            return back()->with('admin_error', 'Ce compte est déjà propriétaire du site, il a déjà tous les accès.');
        }

        try {
            Admin::updateOrCreate(
                ['discord_id' => $discordId],
                ['id' => (string) Str::uuid(), 'label' => $label, 'added_by' => $me['id']]
            );

            return back()->with('admin_ok', 'Accès accordé à ' . ($label ?: $discordId) . '.');
        } catch (\Throwable $e) {
            report($e);

            return back()->with('admin_error', "Impossible d'ajouter cet administrateur. Réessaie.");
        }
    }

    public function removeAdmin(Request $request)
    {
        $me = $this->requireAdmin();
        $discordId = (string) $request->input('discordId');

        // Un propriétaire (.env) ne peut pas être retiré depuis le site.
        if (in_array($discordId, AdminAccess::ownerIds(), true)) {
            return back();
        }

        // Seul un propriétaire peut retirer un autre administrateur.
        if (! AdminAccess::isOwner($me) && $me['id'] !== $discordId) {
            return back();
        }

        Admin::where('discord_id', $discordId)->delete();

        return back();
    }
}
