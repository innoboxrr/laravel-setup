<?php

namespace App\Models\Filters\Role;

use Illuminate\Database\Eloquent\Builder;
use Innoboxrr\SearchSurge\Search\Support\DataContainer;
use Innoboxrr\SearchSurge\Search\Utils\Order;

class NameFilter
{
    public static function apply(Builder $query, DataContainer $data)
    {

        if ($data->name) {

            $query->where('name', 'like', '%' . $data->name . '%');

        }

        $query = Order::orderBy($query, $data, 'name');

        return $query;

    }
}