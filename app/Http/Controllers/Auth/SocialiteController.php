<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    /**
     * Redirect to provider.
     */
    public function redirect(string $provider)
    {
        $this->validateProvider($provider);

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Handle provider callback.
     */
    public function callback(string $provider)
    {
        $this->validateProvider($provider);

        $socialUser = Socialite::driver($provider)->user();

        $user = User::updateOrCreate(
            [
                'email' => $socialUser->getEmail(),
            ],
            [
                'name'              => $socialUser->getName() ?? $socialUser->getNickname() ?? 'Usuario',
                'provider'          => $provider,
                'provider_id'       => $socialUser->getId(),
                'provider_token'    => $socialUser->token,
                'email_verified_at' => now(),
                'password'          => bcrypt(Str::random(24)),
            ]
        );

        Auth::login($user);

        return redirect()->intended('/dashboard');
    }

    /**
     * Validate that the provider is supported.
     */
    private function validateProvider(string $provider): void
    {
        abort_unless(
            in_array($provider, ['github', 'google']),
            404
        );
    }
}
