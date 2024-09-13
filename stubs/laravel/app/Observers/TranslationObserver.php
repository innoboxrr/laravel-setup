<?php

namespace App\Observers;

use App\Models\Translation;

class TranslationObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    // public $afterCommit = true;

    /**
     * Handle the Translation "created" event.
     */
    public function created(Translation $translation): void
    {
        $translation->log('created');
    }

    /**
     * Handle the Translation "updated" event.
     */
    public function updated(Translation $translation): void
    {
        $translation->log('updated');
    }

    /**
     * Handle the Translation "deleted" event.
     */
    public function deleted(Translation $translation): void
    {
        $translation->log('deleted');
    }

    /**
     * Handle the Translation "restored" event.
     */
    public function restored(Translation $translation): void
    {
        $translation->log('restored');
    }

    /**
     * Handle the Translation "forceDeleted" event.
     */
    public function forceDeleted(Translation $translation): void
    {
        $translation->log('forceDeleted');
    }
}
