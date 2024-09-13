<?php

namespace App\Models;

use App\Contracts\Search\SearchableInterface;
use App\Models\Traits\Assignments\UserAssignment;
use App\Models\Traits\Mutators\UserMutators;
use App\Models\Traits\Operations\UserOperations;
use App\Models\Traits\Relations\UserRelations;
use App\Models\Traits\Scopes\UserScopes;
use App\Models\Traits\Storage\UserStorage;
use App\Support\Traits\HasBenefit;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Innoboxrr\LaravelAudit\Support\Traits\Auditable;
use Innoboxrr\LaravelAudit\Support\Traits\LoginAttempts;
use Innoboxrr\Traits\MetaOperations;
use Innoboxrr\Traits\ModelAppendsTrait;
use Laravel\Sanctum\HasApiTokens;
use App\Support\Traits\NotificationsVia;
use App\Support\Traits\Impersonate; // Override from Lab404\Impersonate\Models\Impersonate
use App\Models\Traits\Support\UserStats;
use App\Support\Traits\SearchableTrait;
use App\Models\Traits\Search\UserSearch;

class User extends Authenticatable implements MustVerifyEmail, SearchableInterface
{
    use Auditable,
        HasApiTokens,
        HasBenefit,
        HasFactory,
        LoginAttempts,
        MetaOperations,
        ModelAppendsTrait,
        Notifiable,
        SoftDeletes,
        UserAssignment,
        UserMutators,
        UserOperations,
        UserRelations,
        UserScopes,
        UserStorage,
        NotificationsVia,
        Impersonate,
        UserStats,
        SearchableTrait,
        UserSearch;

    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
        'dob',
        'payload',
        'country_id',
        'language_id',
    ];

    protected $creatable = [
        'name',
        'surname',
        'email',
        'password',
        'dob',
        'country_id',
    ];

    protected $updatable = [
        'name',
        'surname',
        'email',
        'password',
        'dob',
        'country_id',
    ];

    protected $translationable = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'avatar_url',
    ];

    protected $with = [
        'roles',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'payload' => 'array',
    ];

    protected $protected_metas = [
        'stripe_customer_id',
        'courses_in_progress',
        'completed_courses',
        'dedication_time',
        'comments_count',
    ];

    protected $editable_metas = [
        'visibility', // public, private
        
        'blocked', // Bool

        'notifications_settings', // JSON

        'locale',
        'timezone',
        'dark_mode',
        
        'avatar',
        'profile_background',

        'salutation',
        'position',
        'bio_about',
        'bio_experience',
        'bio_education',
        'bio_skills',
    ];

    public static $export_cols = [
        'name',
        'email',
        'password',
        'dob',
        'country_id',
    ];

    public static $loadable_relations = [
        'products',
        'roles',
        'country',
        'enrollments',
        'inProgressEnrollments',
        'completedEnrollments',
        'headTeacherEnrollments',
        'enrollments.course',
        'inProgressEnrollments.course',
        'completedEnrollments.course',
        'headTeacherEnrollments.course',
        'headTeacherEnrollments.course.product',
        'trackers',
        'statisticsReports',
        'comments',
        'voucherSents',
        'attempts',
        'wishlists',
        'carts',
        'paymentMethods',
        'payments',
        'reviews',
        'revenues',
        'payouts',
    ];

    public static $loadable_counts = [
        'products',
        'roles',
        'country',
        'enrollments',
        'trackers',
        'statisticsReports',
        'comments',
        'voucherSents',
        'attempts',
        'wishlists',
        'carts',
        'paymentMethods',
        'payments',
        'reviews',
        'revenues',
        'payouts',
    ];
}
