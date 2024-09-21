<?php

namespace App\Http\Controllers;

use App\Http\Requests\Coupon\AssignProductRequest;
use App\Http\Requests\Coupon\CreateRequest;
use App\Http\Requests\Coupon\DeallocateProductRequest;
use App\Http\Requests\Coupon\DeleteRequest;
use App\Http\Requests\Coupon\ExportRequest;
use App\Http\Requests\Coupon\ForceDeleteRequest;
use App\Http\Requests\Coupon\IndexRequest;
use App\Http\Requests\Coupon\PoliciesRequest;
use App\Http\Requests\Coupon\PolicyRequest;
use App\Http\Requests\Coupon\RestoreRequest;
use App\Http\Requests\Coupon\ShowRequest;
use App\Http\Requests\Coupon\UpdateRequest;

class CouponController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
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

    public function assignProduct(AssignProductRequest $request)
    {
        return $request->handle();
    }

    public function deallocateProduct(DeallocateProductRequest $request)
    {
        return $request->handle();
    }
}
