<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
use App\Notifications\User\WelcomeEmailNotification;
use Innoboxrr\LaravelAuth\Http\Requests\Auth\GetAuthRequest as LaravelAuthGetAuthRequest;
use Innoboxrr\LaravelAuth\Http\Requests\Auth\RegisterRequest as LaravelAuthRegisterRequest;
use Innoboxrr\LaravelAuth\Http\Requests\Socialite\CallbackRequest as LaravelAuthCallbackRequest;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(UrlGenerator $url): void
    {

        if (env('APP_ENV') !== 'local') {
            $url->forceScheme('https');
        }

        // Deactivate wrapping for all resources
        JsonResource::withoutWrapping();

        // Translation custom path
        $this->loadJsonTranslationsFrom(config('app.locales_path'));

        // Define the custom rules for the register request
        LaravelAuthRegisterRequest::setCustomRulesCallback(function ($request) {
            // Define tus reglas personalizadas aquí
            return [
                'email' => ['required', 'email', 'unique:users,email'],
                'password' => ['required', 'min:8', 'confirmed'],
                // Otras reglas personalizadas...
            ];
        });

        LaravelAuthGetAuthRequest::$customGetAuthCallback = function ($user) {
            if ($user) {
                // Custom loaders
            }

            return response()->json([
                'user' => $user,
                'message' => 'User retrieved successfully',
            ]);
        };

        LaravelAuthCallbackRequest::$customLoginCallback = function ($user, $provider) {

            $providerId = $user->getPayload("{$provider}_id");

            if(!$providerId) {
                return redirect('/auth/login?error=register-provider-not-match');
            }
        
            Auth::login($user);

            return redirect('/');
        };

        LaravelAuthCallbackRequest::$customRegisterCallback = function ($providerUser, $provider) {

            $user = app(config('laravel-auth.user-class'));
            $user->name = $providerUser->getName();
            $user->email = $providerUser->getEmail();
            $user->password = Hash::make(Str::random(24));
            $user->email_verified_at = now();
            $user->save();

            $user->metas()->create([
                'key' => 'avatar',
                'value' => $providerUser->getAvatar(),
            ]);

            $user->metas()->create([
                'key' => "{$provider}_id",
                'value' => $providerUser->getId(),
            ]);

            $user->updatePayload();

            Auth::login($user);

            $user->notify(new WelcomeEmailNotification());

            return redirect('/');
        };
    }
}
