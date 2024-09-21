<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    // public $afterCommit = true;

    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $user->log('created');
        $user->updatePayload();
        $user->assignBaseRoles();
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        $user->log('updated');
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        $user->log('deleted');

        // Delete all enrollments
        $user->enrollments->each->delete();
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        $user->log('restored');
    }

    /**
     * Handle the User "forceDeleted" event.
     */
    public function forceDeleted(User $user): void
    {
        $user->log('forceDeleted');
    }
}
