<?php

namespace App\Support\Traits;

use App\Models\Search;

trait SearchableTrait
{

    public function searchs()
    {
        return $this->morphMany(Search::class, 'searchableRelation');
    }

    public function updateSearchableData($locale = null): void
    {
        Search::updateOrCreate(
            [
                'searchable_type' => $this->getSearchSearchableType(),
                'searchable_id' => $this->getSearchSearchableId(),
                'locale' => $locale
            ],
            [
                'term' => $this->getSearchTerm(),
                'description' => $this->getSearchDescription(),
                'link' => $this->getSearchLink(),
                'image' => $this->getSearchImage(),
                'other' => $this->getSearchOther(),
            ]
        );
    }


    public function removeSearchableData($locale = null): void
    {
        Search::where([
            'searchable_type' => $this->getSearchSearchableType(),
            'searchable_id' => $this->getSearchSearchableId(),
            'locale' => $locale
        ])->delete();
        
    }
    
}