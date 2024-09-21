<?php

namespace App\Models\Filters\User;

use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Innoboxrr\SearchSurge\Search\Support\DataContainer;
use Innoboxrr\SearchSurge\Search\Utils\Order;

class HeadTeacherFilter
{
    public static function apply(Builder $query, DataContainer $data)
    {

        if ($data->head_teacher == 'true' || $data->head_teacher == '1') {

            $query->whereHas('roles', function ($q) {
                $q->where('slug', Role::HEAD_TEACHER);
            });

        }

        return $query;

    }
}
