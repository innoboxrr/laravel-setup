<?php

namespace App\Models\Traits\Relations;

use App\Models\Attempt;
use App\Models\Attendance;
use App\Models\Cart;
use App\Models\Comment;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Payout;
use App\Models\Product;
use App\Models\Revenue;
use App\Models\Review;
use App\Models\Role;
use App\Models\Tracker;
use App\Models\UserMeta;
use App\Models\VoucherSent;
use App\Models\Wishlist;
use App\Models\Language;
use App\Models\Bootcamp;
use App\Models\Quiz;
use App\Models\Subscription;
use App\Models\Permission;

// use \Znck\Eloquent\Traits\BelongsToThrough; // Docs: https://github.com/staudenmeir/belongs-to-through
// use \Staudenmeir\EloquentHasManyDeep\HasRelationships; // Docs: https://github.com/staudenmeir/eloquent-has-many-deep

trait UserRelations
{
    public function metas()
    {
        return $this->hasMany(UserMeta::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_user')
            ->withTimestamps();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user')
            ->withTimestamps();
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function inProgressEnrollments()
    {
        return $this->enrollments()->where('status', 'active');
    }

    public function completedEnrollments()
    {
        return $this->enrollments()->where('status', 'completed');
    }

    public function headTeacherEnrollments()
    {
        return $this->enrollments()->where('role', 'head_teacher');
    }

    public function attendances()
    {
        return $this->hasManyThrough(Attendance::class, Enrollment::class);
    }

    public function trackers()
    {
        return $this->hasMany(Tracker::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function voucherSents()
    {
        return $this->hasMany(VoucherSent::class);
    }

    public function attempts()
    {
        return $this->hasMany(Attempt::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function currentCart()
    {
        return $this->hasOne(Cart::class)
            ->where('status', 'current')
            ->where('type', 'one_time');
    }

    public function paymentMethods()
    {
        return $this->hasMany(PaymentMethod::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function revenues()
    {
        return $this->hasMany(Revenue::class);
    }

    public function payouts()
    {
        return $this->hasMany(Payout::class);
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'coupon_user')
            ->withTimestamps();
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function bootcamps()
    {
        return $this->belongsToMany(Bootcamp::class)
            ->withPivot('status', 'role', 'start_at', 'end_at')
            ->withTimestamps();
    }

    public function quizzes()
    {
        return $this->belongsToMany(Quiz::class)
            ->withPivot('status', 'role', 'start_at', 'end_at')
            ->withTimestamps();
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_user')
            ->withPivot('role_id')
            ->withTimestamps();
    }
}
