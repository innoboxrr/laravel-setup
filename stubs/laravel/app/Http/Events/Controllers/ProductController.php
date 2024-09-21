<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\AssignCouponRequest;
use App\Http\Requests\Product\CreateRequest;
use App\Http\Requests\Product\DeallocateCouponRequest;
use App\Http\Requests\Product\DeleteRequest;
use App\Http\Requests\Product\ExportRequest;
use App\Http\Requests\Product\ForceDeleteRequest;
use App\Http\Requests\Product\IndexRequest;
use App\Http\Requests\Product\PoliciesRequest;
use App\Http\Requests\Product\PolicyRequest;
use App\Http\Requests\Product\RestoreRequest;
use App\Http\Requests\Product\ShowRequest;
use App\Http\Requests\Product\StatisticsRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Http\Requests\Product\ReviewsStatisticsRequest;
use App\Http\Requests\Product\StatsOverviewRequest;
use App\Http\Requests\Product\ReviewsSeederRequest;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'reviewsStatistics']);
    }

    public function policies(PoliciesRequest $request)
    {
        return $request->handle($this);
    }

    public function policy(PolicyRequest $request)
    {
        return $request->handle();
    }

    public function index(IndexRequest $request)
    {
        return $request->handle();
    }

    public function show(ShowRequest $request)
    {
        return $request->handle();
    }

    public function create(CreateRequest $request)
    {
        return $request->handle();
    }

    public function update(UpdateRequest $request)
    {
        return $request->handle();
    }

    public function delete(DeleteRequest $request)
    {
        return $request->handle();
    }

    public function restore(RestoreRequest $request)
    {
        return $request->handle();
    }

    public function forceDelete(ForceDeleteRequest $request)
    {
        return $request->handle();
    }

    public function export(ExportRequest $request)
    {
        return $request->handle();
    }

    public function assignCoupon(AssignCouponRequest $request)
    {
        return $request->handle();
    }

    public function deallocateCoupon(DeallocateCouponRequest $request)
    {
        return $request->handle();
    }

    public function statistics(StatisticsRequest $request)
    {
        return $request->handle();
    }

    public function reviewsStatistics(ReviewsStatisticsRequest $request)
    {
        return $request->handle();
    }

    public function statsOverview(StatsOverviewRequest $request)
    {
        return $request->handle();
    }

    public function reviewsSeeder(ReviewsSeederRequest $request)
    {
        return $request->handle();
    }
}
