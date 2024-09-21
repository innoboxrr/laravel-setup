<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentMethod\CreateRequest;
use App\Http\Requests\PaymentMethod\DeleteRequest;
use App\Http\Requests\PaymentMethod\ExportRequest;
use App\Http\Requests\PaymentMethod\ForceDeleteRequest;
use App\Http\Requests\PaymentMethod\IndexRequest;
use App\Http\Requests\PaymentMethod\PoliciesRequest;
use App\Http\Requests\PaymentMethod\PolicyRequest;
use App\Http\Requests\PaymentMethod\RestoreRequest;
use App\Http\Requests\PaymentMethod\ShowRequest;
use App\Http\Requests\PaymentMethod\UpdateRequest;

class PaymentMethodController extends Controller
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
}
