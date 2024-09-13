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

            // Bio
            'salutation' => $this->meta('salutation'),
            'bio_about' => $this->meta('bio_about'),
            'bio_experience' => $this->meta('bio_experience'),
            'bio_education' => $this->meta('bio_education'),
            'bio_skills' => $this->meta('bio_skills'), 
            'position' => $this->meta('position'),

            // Teacher stats
            'teacher_reviews' => $this->meta('teacher_reviews', 0), // Review observers
            'teacher_rating' => $this->meta('teacher_rating', 0), // Review observers
            'teacher_courses' => $this->meta('teacher_courses', 0), // Enrollment observers
            'teacher_students' => $this->meta('teacher_students', 0), // Enrollment observers

            // Student stats
            'student_courses' => $this->meta('student_courses', 0), // Enrollment observers
            'courses_in_progress' => $this->meta('courses_in_progress', 0), // Enrollment observers
            'completed_courses' => $this->meta('completed_courses', 0), // Enrollment observers
            'dedication_time' => $this->meta('dedication_time', 0), // Lecture observers
            'comments_count' => $this->meta('comments_count', 0), // Comment observers

            // Affiliate
            'affiliate_user_id' => $this->meta('affiliate_user_id'), // Para el sistema de afiliados
            'affiliate_code' => $this->meta('affiliate_code'), // Para el sistema de afiliados
            'affiliate_earnings' => $this->meta('affiliate_earnings', 0), // Para el sistema de afiliados
            'affiliate_paid' => $this->meta('affiliate_paid', 0), // Para el sistema de afiliados
            'affiliate_pending' => $this->meta('affiliate_pending', 0), // Para el sistema de afiliados
            'affiliate_withdrawn' => $this->meta('affiliate_withdrawn', 0), // Para el sistema de afiliados
            'affiliate_withdrawn_amount' => $this->meta('affiliate_withdrawn_amount', 0), // Para el sistema de afiliados
            'affiliate_withdrawn_date' => $this->meta('affiliate_withdrawn_date'), // Para el sistema de afiliados
            'affiliate_withdrawn_method' => $this->meta('affiliate_withdrawn_method'), // Para el sistema de afiliados
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

    /**
     * Check if the user is enrolled in a course
     *
     * @param  int|Course  $course
     * @param  array  $status
     * @param  array  $roles
     */
    public function isEnrolled($course, $statuses = ['active'], $roles = ['student'], $cache = true)
    {
        $course = $course instanceof Course ? $course : Course::findOrFail($course);

        if(is_string($statuses)) {
            $statuses = [$statuses];
        }

        if(is_string($roles)) {
            $roles = [$roles];
        }

        sort($statuses);
        sort($roles);
        $statusesKey = implode('-', $statuses);
        $rolesKey = implode('-', $roles);
        $cacheRand = $cache ? '' : rand(1, 1000);
        $cacheKey = "isEnrolled:course{$course->id}:statuses{$statusesKey}:roles{$rolesKey}:{$cacheRand}";

        return Cache::remember($cacheKey, now()->addHours(24), function () use ($course, $roles, $statuses) {
            return $this->enrollments()
                ->where('course_id', $course->id)
                ->where('start_at', '<=', now())
                ->where(function ($query) {
                    $query->whereNull('end_at')
                        ->orWhere('end_at', '>=', now());
                })
                ->whereIn('role', $roles)
                ->whereIn('status', $statuses)
                ->exists();
        });
    }

    public function enroll($course, $status = 'pending', $role = 'student', $end_at = null)
    {
        $course = $course instanceof Course ? $course : Course::findOrFail($course);

        return $this->enrollments()->updateOrCreate([
            'course_id' => $course->id,
        ], [
            'status' => $status,
            'role' => $role,
            'start_at' => now(),
            'end_at' => $end_at,
        ]);
    }

    public function hasActiveBootcamp($bootcampId): bool
    {   
        return $this->bootcamps()
            ->wherePivot('bootcamp_id', $bootcampId)
            ->wherePivot('status', 'active')
            ->exists();
    }

    // DEPRECATED
    public function isCommentViewer($comment)
    {
        return $comment->commentViewers()->where('user_id', $this->id)->exists();
    }

    public function updateStats($updateOnly = [])
    {
        $stats = collect([
            'courses_in_progress' => $this->enrollments()->where('status', 'active')->count(),
            'completed_courses' => $this->enrollments()->where('status', 'completed')->count(),
            'dedication_time' => $this->enrollments()->sum('completed'),
            'comments_count' => $this->comments()->count(),
        ]);

        $stats->each(function ($value, $key) use ($updateOnly) {
            if (!empty($updateOnly) && !in_array($key, $updateOnly)) {
                return;
            }
            $this->metas()->updateOrCreate(['key' => $key], ['value' => $value]);
        });

        $this->updatePayload();
    }

}
