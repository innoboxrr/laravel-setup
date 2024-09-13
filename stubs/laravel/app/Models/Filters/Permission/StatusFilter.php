<?php

namespace App\Models\Filters\Permission;

use Illuminate\Database\Eloquent\Builder;
use Innoboxrr\SearchSurge\Search\Utils\Order;
use Innoboxrr\SearchSurge\Search\Support\DataContainer;

class StatusFilter
{

    public static function apply(Builder $query, DataContainer $data)
    {

        if ($data->status) {

            $query->where('status', $data->status);

        }

        $query = Order::orderBy($query, $data, 'status');

        return $query;

    }

}
