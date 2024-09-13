<?php
 
namespace App\Observers;
 
use App\Models\Permission;
 
class PermissionObserver
{

    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    // public $afterCommit = true;

    /**
     * Handle the Permission "created" event.
     */
    public function created(Permission $permission): void
    {
        // Remove if laravel-audit is used: $permission->log('created');
    }
 
    /**
     * Handle the Permission "updated" event.
     */
    public function updated(Permission $permission): void
    {
        // Remove if laravel-audit is used: $permission->log('updated');
    }
 
    /**
     * Handle the Permission "deleted" event.
     */
    public function deleted(Permission $permission): void
    {
        // Remove if laravel-audit is used: $permission->log('deleted');
    }
 
    /**
     * Handle the Permission "restored" event.
     */
    public function restored(Permission $permission): void
    {
        // Remove if laravel-audit is used: $permission->log('restored');
    }
 
    /**
     * Handle the Permission "forceDeleted" event.
     */
    public function forceDeleted(Permission $permission): void
    {
        // Remove if laravel-audit is used: $permission->log('forceDeleted');
    }
}