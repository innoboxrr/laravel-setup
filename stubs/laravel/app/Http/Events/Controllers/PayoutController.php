<?php

namespace App\Http\Controllers;

use App\Http\Requests\Payout\CreateRequest;
use App\Http\Requests\Payout\DeleteRequest;
use App\Http\Requests\Payout\ExportRequest;
use App\Http\Requests\Payout\ForceDeleteRequest;
use App\Http\Requests\Payout\IndexRequest;
use App\Http\Requests\Payout\PoliciesRequest;
use App\Http\Requests\Payout\PolicyRequest;
use App\Http\Requests\Payout\RestoreRequest;
use App\Http\Requests\Payout\ShowRequest;
use App\Http\Requests\Payout\UpdateRequest;
use App\Http\Requests\Payout\CompleteRequest;

class PayoutController extends Controller
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

    public function complete(CompleteRequest $request)
    {
        return $request->handle();
    }
}
