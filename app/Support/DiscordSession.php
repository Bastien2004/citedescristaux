<?php

namespace App\Support;

/**
 * Équivalent de src/lib/session.ts.
 *
 * L'original stocke l'utilisateur dans un cookie JWT signé (jose).
 * Ici, on s'appuie sur la session Laravel (cookie chiffré côté serveur) :
 * c'est l'équivalent fonctionnel le plus idiomatique côté Laravel.
 */
class DiscordSession
{
    const SESSION_KEY = 'cag_session';

    /**
     * @param array{id:string,username:string,globalName:?string,avatar:?string} $user
     */
    public static function create(array $user): void
    {
        session([self::SESSION_KEY => $user]);
    }

    /**
     * @return array{id:string,username:string,globalName:?string,avatar:?string}|null
     */
    public static function user(): ?array
    {
        return session(self::SESSION_KEY);
    }

    public static function destroy(): void
    {
        session()->forget(self::SESSION_KEY);
    }

    /** Nom affichable : pseudo global si défini, sinon username. */
    public static function displayName(array $user): string
    {
        return $user['globalName'] ?: $user['username'];
    }

    public static function avatarUrl(array $user): string
    {
        if (empty($user['avatar'])) {
            // Les identifiants Discord (snowflakes) tiennent dans un entier 64 bits :
            // pas besoin de bcmath/gmp pour ce calcul.
            $index = ((int) $user['id'] >> 22) % 6;
            return "https://cdn.discordapp.com/embed/avatars/{$index}.png";
        }

        return "https://cdn.discordapp.com/avatars/{$user['id']}/{$user['avatar']}.png?size=128";
    }
}
