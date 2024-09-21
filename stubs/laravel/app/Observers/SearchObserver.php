<?php
 
namespace App\Observers;
 
use App\Models\Search;
 
class SearchObserver
{

    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    // public $afterCommit = true;

    /**
     * Handle the Search "created" event.
     */
    public function created(Search $search): void
    {
        // Remove if laravel-audit is used: $search->log('created');
    }
 
    /**
     * Handle the Search "updated" event.
     */
    public function updated(Search $search): void
    {
        // Remove if laravel-audit is used: $search->log('updated');
    }
 
    /**
     * Handle the Search "deleted" event.
     */
    public function deleted(Search $search): void
    {
        // Remove if laravel-audit is used: $search->log('deleted');
    }
 
    /**
     * Handle the Search "restored" event.
     */
    public function restored(Search $search): void
    {
        // Remove if laravel-audit is used: $search->log('restored');
    }
 
    /**
     * Handle the Search "forceDeleted" event.
     */
    public function forceDeleted(Search $search): void
    {
        // Remove if laravel-audit is used: $search->log('forceDeleted');
    }
}