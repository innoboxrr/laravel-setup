<?php

namespace App\Models\Filters\Role;

use Illuminate\Database\Eloquent\Builder;
use Innoboxrr\SearchSurge\Search\Support\DataContainer;
use Innoboxrr\SearchSurge\Search\Utils\Order;

class SlugFilter
{
    public static function apply(Builder $query, DataContainer $data)
    {

        if ($data->slug) {

            $query->where('slug', $data->slug);

        }

        $query = Order::orderBy($query, $data, 'slug');

        return $query;

    }
}
