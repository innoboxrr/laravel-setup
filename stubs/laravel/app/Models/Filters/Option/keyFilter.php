<?php

namespace App\Models\Filters\Option;

use Illuminate\Database\Eloquent\Builder;
use Innoboxrr\SearchSurge\Search\Support\DataContainer;
use Innoboxrr\SearchSurge\Search\Utils\Order;

class keyFilter
{
    public static function apply(Builder $query, DataContainer $data)
    {

        if ($data->key) {

            $query->where('key', 'like', '%' . $data->key . '%');

        }

        $query = Order::orderBy($query, $data, 'key');

        return $query;

    }
}
