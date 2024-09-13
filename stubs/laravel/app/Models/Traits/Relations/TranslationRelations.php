<?php

namespace App\Models\Traits\Relations;

use App\Models\Language;

// use \Znck\Eloquent\Traits\BelongsToThrough; // Docs: https://github.com/staudenmeir/belongs-to-through
// use \Staudenmeir\EloquentHasManyDeep\HasRelationships; // Docs: https://github.com/staudenmeir/eloquent-has-many-deep

trait TranslationRelations
{
    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function translationable()
    {
        return $this->morphTo();
    }
}
