<?php

namespace App\Models\Filters\User;

use Illuminate\Database\Eloquent\Builder;
use Innoboxrr\SearchSurge\Search\Support\DataContainer;

class EagerLoadingFilter
{
    public static function apply(Builder $query, DataContainer $data)
    {
        if ($data->load_products == 1 || $data->load_products == true) {

            $query->with(['products']);

        }

        if ($data->load_roles == 1 || $data->load_roles == true) {

            $query->with(['roles']);

        }

        if ($data->load_country == 1 || $data->load_country == true) {

            $query->with(['country']);

        }

        if ($data->load_enrollments == 1 || $data->load_enrollments == true) {

            $query->with(['enrollments']);

        }

        if ($data->load_trackers == 1 || $data->load_trackers == true) {

            $query->with(['trackers']);

        }

        if ($data->load_statistics_reports == 1 || $data->load_statistics_reports == true) {

            $query->with(['statisticsReports']);

        }

        if ($data->load_comments == 1 || $data->load_comments == true) {

            $query->with(['comments']);

        }

        if ($data->load_voucher_sents == 1 || $data->load_voucher_sents == true) {

            $query->with(['voucherSents']);

        }

        if ($data->load_attempts == 1 || $data->load_attempts == true) {

            $query->with(['attempts']);

        }

        if ($data->load_wishlists == 1 || $data->load_wishlists == true) {

            $query->with(['wishlists']);

        }

        if ($data->load_carts == 1 || $data->load_carts == true) {

            $query->with(['carts']);

        }

        if ($data->load_payment_methods == 1 || $data->load_payment_methods == true) {

            $query->with(['paymentMethods']);

        }

        if ($data->load_payments == 1 || $data->load_payments == true) {

            $query->with(['payments']);

        }

        if ($data->load_reviews == 1 || $data->load_reviews == true) {

            $query->with(['reviews']);

        }

        if ($data->load_revenues == 1 || $data->load_revenues == true) {

            $query->with(['revenues']);

        }

        if ($data->load_payouts == 1 || $data->load_payouts == true) {

            $query->with(['payouts']);

        }
        /*

        if ($data->load_relation == 1 || $data->load_relation == true) {

            $query->with(['relation']);

        }

        */

        return $query;

    }
}
