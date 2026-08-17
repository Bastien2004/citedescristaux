<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Support\DiscordOAuth;
use App\Support\DiscordSession;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DiscordAuthController extends Controller
{
    /** Équivalent de src/app/api/auth/discord/route.ts */
    public function redirect(Request $request)
    {
        $next = $request->query('next', '/inscription');

        $state = (string) Str::uuid();

        session([
            'cag_oauth_state' => $state,
            'cag_oauth_next' => Str::startsWith($next, '/') ? $next : '/inscription',
        ]);

        try {
            return redirect()->away(DiscordOAuth::authorizeUrl($state));
        } catch (\Throwable $e) {
            return redirect(DiscordOAuth::siteUrl() . '/inscription?error=config');
        }
    }

    /** Équivalent de src/app/api/auth/callback/discord/route.ts */
    public function callback(Request $request)
    {
        $code = $request->query('code');
        $state = $request->query('state');

        $expectedState = session('cag_oauth_state');
        $next = session('cag_oauth_next', '/inscription');

        session()->forget(['cag_oauth_state', 'cag_oauth_next']);

        if ($request->query('error')) {
            return redirect(DiscordOAuth::siteUrl() . '/inscription?error=denied');
        }

        if (! $code || ! $state || ! $expectedState || $state !== $expectedState) {
            return redirect(DiscordOAuth::siteUrl() . '/inscription?error=state');
        }

        try {
            $token = DiscordOAuth::exchangeCode($code);
            $profile = DiscordOAuth::fetchUser($token['access_token']);

            DiscordSession::create([
                'id' => $profile['id'],
                'username' => $profile['username'],
                'globalName' => $profile['global_name'] ?? null,
                'avatar' => $profile['avatar'] ?? null,
            ]);

            return redirect(DiscordOAuth::siteUrl() . $next);
        } catch (\Throwable $e) {
            report($e);

            return redirect(DiscordOAuth::siteUrl() . '/inscription?error=oauth');
        }
    }

    /** Équivalent de src/app/api/auth/logout/route.ts */
    public function logout()
    {
        DiscordSession::destroy();

        return redirect(DiscordOAuth::siteUrl() . '/');
    }
}
