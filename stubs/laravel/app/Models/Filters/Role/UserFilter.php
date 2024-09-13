<?php

namespace App\Models\Filters\Role;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Innoboxrr\SearchSurge\Search\Support\DataContainer;

class UserFilter
{
    public static function apply(Builder $query, DataContainer $data)
    {

        if ($data->user_id) {
            $roleIds = DB::table('role_user')
                ->select('role_id')
                ->where('user_id', $data->user_id)
                ->pluck('role_id');

            $query->whereIn('id', $roleIds);
        }

        return $query;

    }
}
