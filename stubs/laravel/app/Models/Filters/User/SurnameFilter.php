<?php

namespace App\Models\Filters\User;

use Illuminate\Database\Eloquent\Builder;
use Innoboxrr\SearchSurge\Search\Support\DataContainer;
use Innoboxrr\SearchSurge\Search\Utils\Order;

class SurnameFilter
{
    public static function apply(Builder $query, DataContainer $data)
    {

        if ($data->surname) {

            $query->where('surname', 'like', '%' . $data->surname . '%');
        }

        $query = Order::orderBy($query, $data, 'surname');

        return $query;
    }
}
