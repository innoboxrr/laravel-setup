<?php

namespace App\Models\Filters\Role;

use Illuminate\Database\Eloquent\Builder;
use Innoboxrr\SearchSurge\Search\Support\DataContainer;

class EagerLoadingFilter
{
    public static function apply(Builder $query, DataContainer $data)
    {

        if ($data->load_permissions == 1 || $data->load_permissions == true) {

            $query->with(['permissions']);

        }

        if ($data->load_users == 1 || $data->load_users == true) {

            $query->with(['users']);

        }

        /*

        if ($data->load_relation == 1 || $data->load_relation == true) {

            $query->with(['relation']);

        }

        */

        return $query;

    }
}
