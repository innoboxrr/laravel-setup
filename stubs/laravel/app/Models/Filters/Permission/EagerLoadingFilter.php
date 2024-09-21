<?php

namespace App\Models\Filters\Permission;

use Illuminate\Database\Eloquent\Builder;
use Innoboxrr\SearchSurge\Search\Utils\Order;
use Innoboxrr\SearchSurge\Search\Support\DataContainer;

class EagerLoadingFilter
{

    public static function apply(Builder $query, DataContainer $data)
    {

        if ($data->load_roles == 1 || $data->load_roles == true) {

            $query->with(['roles']);

        }

        if($data->load_user_permissions) {
            $query->with(['users' =>function($query) use ($data) {
                $query->where('user_id', $data->load_user_permissions);
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
