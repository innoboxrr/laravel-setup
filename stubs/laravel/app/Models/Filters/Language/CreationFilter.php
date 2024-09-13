<?php

namespace App\Models\Filters\Language;

use Illuminate\Database\Eloquent\Builder;
use Innoboxrr\SearchSurge\Search\Support\DataContainer;
use Innoboxrr\SearchSurge\Search\Utils\CreationFilterQuery;
use Innoboxrr\SearchSurge\Search\Utils\Order;

class CreationFilter
{
    public static function apply(Builder $query, DataContainer $data)
    {

        $query = CreationFilterQuery::sort($query, $data);

        $query = Order::orderBy($query, $data, 'created_at');

        return $query;

    }
}
