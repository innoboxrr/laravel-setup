<?php

namespace App\Models\Traits\Operations;

use App\Models\Course;
use App\Models\Role;
use App\Notifications\User\EmailVerification;
use App\Notifications\User\OTPNotification;
use App\Notifications\User\DirectResetPasswordNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Faker\Factory as Faker;

trait UserOperations
{
    public function buildPayload()
    {
        return [
            // Settings
            'locale' => $this->meta('locale', 'en'),
            'timezone' => $this->meta('timezone', 'UTC'),
            'dark_mode' => $this->meta('dark_mode', 0),

            // Notifications
            'notifications_settings' => $this->meta('notifications_settings'),

            // Stripe
            'stripe_customer_id' => $this->meta('stripe_customer_id'),
            'currency' => $this->meta('currency', 'USD'),

            // Social oAuth
            'google_id' => $this->meta('google_id'),
            'facebook_id' => $this->meta('facebook_id'),
            'microsoft_id' => $this->meta('microsoft_id'),
            'github_id' => $this->meta('github_id'),

            // User statuses
            'blocked' => $this->meta('blocked', 0),
            'visibility' => $this->meta('visibility', 'public'),
            'delete_origin' => $this->meta('delete_origin'),

            // Other
            'avatar' => $this->meta('avatar'),
            'profile_background' => $this->meta('profile_background'),

        ];
    }

    public function updatePayload()
    {
        $this->payload = $this->buildPayload();
        return $this->save();
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new EmailVerification($this));
    }

    public function sendOTPModel($expires = 5)
    {
        $otp = rand(100000, 999999);
        $this->otp = bcrypt($otp);
        $this->otp_expires_at = now()->addMinutes($expires);
        $this->save();
        $this->notify(new OTPNotification($this, $otp));
    }

    public function verifyOTP($otp)
    {
        if ($this->otp_expires_at < now()) {
            return false;
        }
        if (password_verify($otp, $this->otp)) {
            $this->otp = null;
            $this->otp_expires_at = null;
            $this->save();
            return true;
        }
        return false;
    }

    public function sendDirectResetPasswordLink()
    {
        $this->notify(new DirectResetPasswordNotification($this));
    }

    public function directResetPasswordLink($password)
    {
        $this->password = bcrypt($password);
        $this->save();
    }

    public function logoutOtherDevicesModel()
    {
        $currentSessionId = session()->getId();
        DB::table('sessions')->where('user_id', Auth::id())->where('id', '!=', $currentSessionId)->delete();
        $currentToken = $this->currentAccessToken();
        $this->tokens()->where('id', '!=', $currentToken?->id)->delete();
    }

    public function deleteAccountModel()
    {
        $currentModelObject = $this->toJson();
        $this->metas()->updateOrCreate(['key' => 'delete_origin'], ['value' => $currentModelObject]);
        $this->updatePayload();
        // Name, Surname, Email, Dob Faker
        $faker = Faker::create();
        $this->update([
            //'name' => $faker->firstName(),
            ///'surname' => $faker->lastName(),
            'email' => $faker->unique()->safeEmail(),
            //'dob' => $faker->date($format = 'Y-m-d', $max = 'now')
        ]);
        // Clossing all sessions
        DB::table('sessions')->where('user_id', Auth::id())->delete();
        // Deleting all tokens
        $this->tokens()->delete();
    }

    public function isAdmin(): bool
    {
        return $this->hasRole(Role::ADMIN) || $this->id === 1;
    }

    public function hasRole($role): bool
    {
        $cacheKey = "user:{$this->id}:hasRole:{$role}";

        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($role) {
            return $this->roles()->where('slug', $role)->exists();
        });
    }

    public function hasRoles(array $roles = []): bool
    {
        sort($roles);
        $rolesKey = implode('-', $roles);
        $cacheKey = "user:{$this->id}:hasRoles:{$rolesKey}";

        return Cache::remember($cacheKey, now()->addHours(5), function () use ($roles) {
            return $this->roles()->whereIn('slug', $roles)->exists();
        });
    }

    public function assignBaseRoles()
    {
        $this->roles()->syncWithoutDetaching([
            Role::where('slug', Role::USER)->first()->id,
            Role::where('slug', Role::STUDENT)->first()->id,
        ]);
    }

    public function isBlocked(): bool
    {
        return $this->getPayload('blocked', 0) == 1;
    }
}
