<?php

namespace App\Observers;

use App\Models\Role;

class RoleObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    // public $afterCommit = true;

    /**
     * Handle the Role "created" event.
     */
    public function created(Role $role): void
    {
        $role->log('created');
    }

    /**
     * Handle the Role "updated" event.
     */
    public function updated(Role $role): void
    {
        $role->log('updated');
    }

    /**
     * Handle the Role "deleted" event.
     */
    public function deleted(Role $role): void
    {
        $role->log('deleted');
    }

    /**
     * Handle the Role "restored" event.
     */
    public function restored(Role $role): void
    {
        $role->log('restored');
    }

    /**
     * Handle the Role "forceDeleted" event.
     */
    public function forceDeleted(Role $role): void
    {
        $role->log('forceDeleted');
    }
}
