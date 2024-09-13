<?php

namespace App\Models\Filters\Language;

use Illuminate\Database\Eloquent\Builder;
use Innoboxrr\SearchSurge\Search\Support\DataContainer;

class EagerLoadingFilter
{
    public static function apply(Builder $query, DataContainer $data)
    {
        if ($data->load_translations == 1 || $data->load_translations == true) {

            $query->with(['translations']);

        }

        if($data->load_subtitles == 1 || $data->load_subtitles == true) {
            $query->with(['subtitles' => function($query) use ($data) {
                if ($data->video_id) {
                    $query->where('subtitles.video_id', $data->video_id);
                }
            }]);
        }
        /*

        if ($data->load_relation == 1 || $data->load_relation == true) {

            $query->with(['relation']);

        }

        */

        return $query;

    }
}
