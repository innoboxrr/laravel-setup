<?php

namespace App\Http\Controllers;

use App\Http\Requests\Payment\CreateRequest;
use App\Http\Requests\Payment\DeleteRequest;
use App\Http\Requests\Payment\ExportRequest;
use App\Http\Requests\Payment\ForceDeleteRequest;
use App\Http\Requests\Payment\IndexRequest;
use App\Http\Requests\Payment\PoliciesRequest;
use App\Http\Requests\Payment\PolicyRequest;
use App\Http\Requests\Payment\RestoreRequest;
use App\Http\Requests\Payment\ShowRequest;
use App\Http\Requests\Payment\UpdateRequest;

class PaymentController extends Controller
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
