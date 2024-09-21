<?php

namespace App\Models\Filters\User;

use Illuminate\Database\Eloquent\Builder;
use Innoboxrr\SearchSurge\Search\Support\DataContainer;

class BootcampFilter
{
    public static function apply(Builder $query, DataContainer $data)
    {

        if ($data->bootcamp_id) {
            $query->whereHas('bootcamps', function ($query) use ($data) {
                $query->where('bootcamp_user.bootcamp_id', $data->bootcamp_id);
            })->with(['bootcamps' => function ($query) use ($data) {
                $query->where('bootcamp_user.bootcamp_id', $data->bootcamp_id);
            }]);
        }

        return $query;

    }
}
