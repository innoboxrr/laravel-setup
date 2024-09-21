<?php

namespace App\Models\Filters\User;

use Illuminate\Database\Eloquent\Builder;
use Innoboxrr\SearchSurge\Search\Support\DataContainer;

class GlobalFilter
{
    public static function apply(Builder $query, DataContainer $data)
    {

        if ($data->global) {

            $query->where(function ($query) use ($data) {
                $query->where('name', 'like', '%'.$data->global.'%')
                    ->orWhere('surname', 'like', '%'.$data->global.'%')
                    ->orWhere('email', 'like', '%'.$data->global.'%');
            });

        }

        return $query;

    }
}
