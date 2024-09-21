<?php

namespace App\Models\Filters\Translation;

use Illuminate\Database\Eloquent\Builder;
use Innoboxrr\SearchSurge\Search\Support\DataContainer;

class EagerLoadingFilter
{
    public static function apply(Builder $query, DataContainer $data)
    {
        if ($data->load_language == 1 || $data->load_language == true) {

            $query->with(['language']);

        }

        if ($data->load_translatable == 1 || $data->load_translatable == true) {

            $query->with(['translatable']);

        }
        /*

        if ($data->load_relation == 1 || $data->load_relation == true) {

            $query->with(['relation']);

        }

        */

        return $query;

    }
}
