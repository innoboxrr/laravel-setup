<?php
 
namespace App\Observers;
 
use App\Models\TrackingEvent;
 
class TrackingEventObserver
{

    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    // public $afterCommit = true;

    /**
     * Handle the TrackingEvent "created" event.
     */
    public function created(TrackingEvent $trackingEvent): void
    {
        // Remove if laravel-audit is used: $trackingEvent->log('created');
    }
 
    /**
     * Handle the TrackingEvent "updated" event.
     */
    public function updated(TrackingEvent $trackingEvent): void
    {
        // Remove if laravel-audit is used: $trackingEvent->log('updated');
    }
 
    /**
     * Handle the TrackingEvent "deleted" event.
     */
    public function deleted(TrackingEvent $trackingEvent): void
    {
        // Remove if laravel-audit is used: $trackingEvent->log('deleted');
    }
 
    /**
     * Handle the TrackingEvent "restored" event.
     */
    public function restored(TrackingEvent $trackingEvent): void
    {
        // Remove if laravel-audit is used: $trackingEvent->log('restored');
    }
 
    /**
     * Handle the TrackingEvent "forceDeleted" event.
     */
    public function forceDeleted(TrackingEvent $trackingEvent): void
    {
        // Remove if laravel-audit is used: $trackingEvent->log('forceDeleted');
    }
}