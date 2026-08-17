<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Team;
use App\Support\AdminAccess;
use App\Support\DiscordSession;
use Illuminate\Http\Request;
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
