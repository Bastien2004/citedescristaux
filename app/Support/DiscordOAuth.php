<?php

namespace App\Support;

use Illuminate\Support\Facades\Http;

/**
 * Authentification Discord OAuth2 (Authorization Code Grant).
 * Équivalent de src/lib/discord.ts — implémentation "à la main", sans
 * dépendance externe, exactement comme l'original.
 */
class DiscordOAuth
{
    const DISCORD_API = 'https://discord.com/api/v10';

    public static function siteUrl(): string
    {
        return rtrim((string) config('app.url'), '/');
    }

    public static function redirectUri(): string
    {
        return self::siteUrl() . '/api/auth/callback/discord';
    }

    public static function authorizeUrl(string $state): string
    {
        $clientId = env('DISCORD_CLIENT_ID');
        if (! $clientId) {
            throw new \RuntimeException('DISCORD_CLIENT_ID est manquant dans le .env');
        }

        $params = http_build_query([
            'client_id' => $clientId,
            'redirect_uri' => self::redirectUri(),
            'response_type' => 'code',
            'scope' => 'identify',
            'state' => $state,
            'prompt' => 'consent',
        ]);

        return "https://discord.com/oauth2/authorize?{$params}";
    }

    /** @return array{access_token:string, token_type:string} */
    public static function exchangeCode(string $code): array
    {
        $clientId = env('DISCORD_CLIENT_ID');
        $clientSecret = env('DISCORD_CLIENT_SECRET');

        if (! $clientId || ! $clientSecret) {
            throw new \RuntimeException('DISCORD_CLIENT_ID / DISCORD_CLIENT_SECRET manquants dans le .env');
        }

        $response = Http::asForm()->post(self::DISCORD_API . '/oauth2/token', [
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => self::redirectUri(),
        ]);

        if (! $response->successful()) {
            throw new \RuntimeException("Échec de l'échange du code Discord ({$response->status()})");
        }

        return $response->json();
    }

    /** @return array{id:string, username:string, global_name:?string, avatar:?string} */
    public static function fetchUser(string $accessToken): array
    {
        $response = Http::withToken($accessToken)->get(self::DISCORD_API . '/users/@me');

        if (! $response->successful()) {
            throw new \RuntimeException("Impossible de récupérer le profil Discord ({$response->status()})");
        }

        return $response->json();
    }
}
