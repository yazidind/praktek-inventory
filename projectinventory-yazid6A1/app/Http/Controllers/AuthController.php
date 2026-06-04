<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login', [
            'provider' => $this->provider(),
        ]);
    }

    public function redirect(): RedirectResponse
    {
        $provider = $this->provider();
        if (! $this->providerIsConfigured($provider)) {
            return redirect()->route('login')->withErrors('Konfigurasi OAuth Google belum lengkap di .env.');
        }

        return Socialite::driver($provider)->redirect();
    }

    public function callback(): RedirectResponse
    {
        $provider = $this->provider();
        if (! $this->providerIsConfigured($provider)) {
            return redirect()->route('login')->withErrors('Konfigurasi OAuth Google belum lengkap di .env.');
        }

        $oauthUser = Socialite::driver($provider)->user();

        $user = User::updateOrCreate(
            [
                'oauth_provider' => $provider,
                'oauth_id' => $oauthUser->getId(),
            ],
            [
                'name' => $oauthUser->getName() ?: $oauthUser->getNickname() ?: $oauthUser->getEmail(),
                'email' => $oauthUser->getEmail(),
                'avatar' => $oauthUser->getAvatar(),
                'email_verified_at' => now(),
            ],
        );

        Auth::login($user, remember: true);

        return redirect()->intended(route('dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'Anda berhasil keluar.');
    }

    private function provider(): string
    {
        return config('services.oauth.provider', 'google');
    }

    private function providerIsConfigured(string $provider): bool
    {
        return $provider === 'google'
            && filled(config('services.google.client_id'))
            && filled(config('services.google.client_secret'));
    }
}
