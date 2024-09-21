<?php

namespace App\Models\Traits\Mutators;

use Innoboxrr\OmniBilling\Services\BillingService;
use App\Support\Traits\OmnibillingTrait;

trait UserMutators
{
    use OmnibillingTrait;

    public function getFullNameAttribute()
    {
        // The database has the columns 'name' and 'surname' but if the surname is null, it will return only the name, otherwise it will return the name and the surname
        return $this->name . ($this->surname ? ' ' . $this->surname : '');
    }

    public function getAvatarUrlAttribute()
    {
        if ($this->getPayload('avatar')) {
            return $this->getPayload('avatar'); // Pending: Check if the files will be stored in local o S3
        } else {
            return 'https://ui-avatars.com/api/?name='.$this->name.'&color=7F9CF5&background=EBF4FF';
        }
    }

    public function getProfileBackgroundUrlAttribute()
    {
        if ($this->getPayload('profile_background')) {
            return $this->getPayload('profile_background'); // Pending: Check if the files will be stored in local o S3
        } else {
            return 'https://picsum.photos/1920/1080';
        }
    }

    public function getCoursesInProgressAttribute()
    {
        return $this->getPayload('courses_in_progress', 0);
    }

    public function getCompletedCoursesAttribute()
    {
        return $this->getPayload('completed_courses', 0);
    }

    public function getDedicationTimeAttribute()
    {
        return $this->getPayload('dedication_time', 0);
    }

    public function getCommentsCountAttribute()
    {
        return $this->getPayload('comments_count', 0);
    }

    public function getStripeCustomerIdAttribute()
    {
        return $this->getPayload('stripe_customer_id');
    }

    public function getStripeCustomerPortalAttribute()
    {
        $billingService = new BillingService('stripe');
        $customerId = $this->getStripeCustomerId($billingService, $this);
        return $billingService->createCustomerPortalSession($customerId);
    }

    public function getBioAboutAttribute()
    {
        return $this->getPayload('bio_about');
    }
}
