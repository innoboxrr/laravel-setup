<?php

namespace App\Http\Controllers;

use App\Http\Requests\Subscription\CreateRequest;
use App\Http\Requests\Subscription\DeleteRequest;
use App\Http\Requests\Subscription\ExportRequest;
use App\Http\Requests\Subscription\ForceDeleteRequest;
use App\Http\Requests\Subscription\IndexRequest;
use App\Http\Requests\Subscription\PoliciesRequest;
use App\Http\Requests\Subscription\PolicyRequest;
use App\Http\Requests\Subscription\RestoreRequest;
use App\Http\Requests\Subscription\ShowRequest;
use App\Http\Requests\Subscription\UpdateRequest;

class SubscriptionController extends Controller
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
