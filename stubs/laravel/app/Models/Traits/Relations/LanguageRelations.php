<?php

namespace App\Models\Traits\Relations;

use App\Models\Subtitle;
use App\Models\Translation;
use App\Models\User;
use App\Models\Video;

// use \Znck\Eloquent\Traits\BelongsToThrough; // Docs: https://github.com/staudenmeir/belongs-to-through
// use \Staudenmeir\EloquentHasManyDeep\HasRelationships; // Docs: https://github.com/staudenmeir/eloquent-has-many-deep

trait LanguageRelations
{
    public function translations()
    {
        return $this->hasMany(Translation::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function subtitles()
    {
        return $this->hasMany(Subtitle::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }
}
