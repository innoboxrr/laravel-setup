<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\ApplyCouponRequest;
use App\Http\Requests\Cart\CheckoutCallbackRequest;
use App\Http\Requests\Cart\CheckoutRequest;
use App\Http\Requests\Cart\CreateRequest;
use App\Http\Requests\Cart\DeleteRequest;
use App\Http\Requests\Cart\ExportRequest;
use App\Http\Requests\Cart\ForceDeleteRequest;
use App\Http\Requests\Cart\IndexRequest;
use App\Http\Requests\Cart\PoliciesRequest;
use App\Http\Requests\Cart\PolicyRequest;
use App\Http\Requests\Cart\AttachUserRequest;
use App\Http\Requests\Cart\RecalculateRequest;
use App\Http\Requests\Cart\RestoreRequest;
use App\Http\Requests\Cart\ShowRequest;
use App\Http\Requests\Cart\UpdateRequest;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show', 'create', 'update', 'recalculate']);
        $this->middleware('throttle:180,1')->only(['index', 'show', 'create', 'update', 'recalculate']);
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

    public function attachUser(AttachUserRequest $request)
    {
        return $request->handle();
    }

    public function recalculate(RecalculateRequest $request)
    {
        return $request->handle();
    }

    public function applyCoupon(ApplyCouponRequest $request)
    {
        return $request->handle();
    }

    public function checkout(CheckoutRequest $request)
    {
        return $request->handle();
    }

    public function checkoutCallback(CheckoutCallbackRequest $request)
    {
        return $request->handle();
    }
}
