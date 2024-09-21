<?php

namespace App\Observers;

use App\Jobs\Language\CreateLocaleJsonFile;
use App\Models\Language;

class LanguageObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    // public $afterCommit = true;

    /**
     * Handle the Language "created" event.
     */
    public function created(Language $language): void
    {
        $language->log('created');
        CreateLocaleJsonFile::dispatch($language);
    }

    /**
     * Handle the Language "updated" event.
     */
    public function updated(Language $language): void
    {
        $language->log('updated');
    }

    /**
     * Handle the Language "deleted" event.
     */
    public function deleted(Language $language): void
    {
        $language->log('deleted');
    }

    /**
     * Handle the Language "restored" event.
     */
    public function restored(Language $language): void
    {
        $language->log('restored');
    }

    /**
     * Handle the Language "forceDeleted" event.
     */
    public function forceDeleted(Language $language): void
    {
        $language->log('forceDeleted');
    }
}
