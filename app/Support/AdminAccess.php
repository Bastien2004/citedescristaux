<?php

namespace App\Support;

use App\Models\Admin;

/**
 * Équivalent de src/lib/admin.ts.
 *
 * Deux niveaux d'accès :
 *  - PROPRIÉTAIRE : identifiant listé dans ADMIN_DISCORD_IDS (.env). Accès
 *    garanti, impossible à retirer depuis le site.
 *  - ADMIN : ajouté depuis le panel, stocké en base. Peut tout faire sauf
 *    retirer un propriétaire.
 */
class AdminAccess
{
    /** @return string[] */
    public static function ownerIds(): array
    {
        $raw = (string) env('ADMIN_DISCORD_IDS', '');

        return collect(explode(',', $raw))
            ->map(fn ($s) => trim($s))
            ->filter()
            ->values()
            ->all();
    }

    public static function isOwner(?array $user): bool
    {
        if (! $user) {
            return false;
        }

        return in_array($user['id'], self::ownerIds(), true);
    }

    /** Vrai si l'utilisateur a accès au panel (propriétaire OU admin en base). */
    public static function isAdmin(?array $user): bool
    {
        if (! $user) {
            return false;
        }

        if (self::isOwner($user)) {
            return true;
        }

        try {
            return Admin::where('discord_id', $user['id'])->exists();
        } catch (\Throwable $e) {
            // Base injoignable : on ne s'appuie que sur la liste du .env.
            return false;
        }
    }
}
