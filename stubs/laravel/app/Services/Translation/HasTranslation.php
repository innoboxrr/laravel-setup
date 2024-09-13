<?php

namespace App\Services\Translation;

use App\Models\Translation;

trait HasTranslation
{
    public function tranlsations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    /**
     * Usage: $model->translation($languageId)->first();
     */
    public function translation($languageId)
    {
        return $this->morphOne(Translation::class, 'translatable')->where('language_id', $languageId);
    }
}
