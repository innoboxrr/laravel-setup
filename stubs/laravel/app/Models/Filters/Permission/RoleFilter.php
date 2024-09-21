<?php

namespace App\Models\Filters\Permission;

use Illuminate\Database\Eloquent\Builder;
use Innoboxrr\SearchSurge\Search\Utils\Order;
use Innoboxrr\SearchSurge\Search\Support\DataContainer;

class RoleFilter
{

    public static function apply(Builder $query, DataContainer $data)
    {
        if ($data->role_ids && is_array($data->role_ids)) {
            $query->whereHas('roles', function ($query) use ($data) {
                $query->whereIn('roles.id', $data->role_ids);
            });
        }
        return $query;
    }

}
