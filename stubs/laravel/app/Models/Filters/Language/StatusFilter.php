<?php

namespace App\Models\Filters\Language;

use Illuminate\Database\Eloquent\Builder;
use Innoboxrr\SearchSurge\Search\Support\DataContainer;
use Innoboxrr\SearchSurge\Search\Utils\Order;

class StatusFilter
{
    public static function apply(Builder $query, DataContainer $data)
    {

        if ($data->status == '1' || $data->status === 1) {

            $query->where('status', true);

        }

        return $query;

    }

}
