<?php

namespace App\Http\Controllers;

use App\Http\Requests\VoucherSent\CreateRequest;
use App\Http\Requests\VoucherSent\DeleteRequest;
use App\Http\Requests\VoucherSent\ExportRequest;
use App\Http\Requests\VoucherSent\ForceDeleteRequest;
use App\Http\Requests\VoucherSent\IndexRequest;
use App\Http\Requests\VoucherSent\PoliciesRequest;
use App\Http\Requests\VoucherSent\PolicyRequest;
use App\Http\Requests\VoucherSent\RestoreRequest;
use App\Http\Requests\VoucherSent\ShowRequest;
use App\Http\Requests\VoucherSent\UpdateRequest;

class VoucherSentController extends Controller
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
