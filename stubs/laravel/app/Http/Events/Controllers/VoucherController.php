<?php

namespace App\Http\Controllers;

use App\Http\Requests\Voucher\CreateRequest;
use App\Http\Requests\Voucher\DeleteRequest;
use App\Http\Requests\Voucher\ExportRequest;
use App\Http\Requests\Voucher\ForceDeleteRequest;
use App\Http\Requests\Voucher\IndexRequest;
use App\Http\Requests\Voucher\PoliciesRequest;
use App\Http\Requests\Voucher\PolicyRequest;
use App\Http\Requests\Voucher\RestoreRequest;
use App\Http\Requests\Voucher\ShowRequest;
use App\Http\Requests\Voucher\UpdateRequest;

class VoucherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
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
