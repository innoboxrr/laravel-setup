<?php

namespace App\Http\Controllers;

use App\Http\Requests\Revenue\CreateRequest;
use App\Http\Requests\Revenue\DeleteRequest;
use App\Http\Requests\Revenue\ExportRequest;
use App\Http\Requests\Revenue\ForceDeleteRequest;
use App\Http\Requests\Revenue\IndexRequest;
use App\Http\Requests\Revenue\PoliciesRequest;
use App\Http\Requests\Revenue\PolicyRequest;
use App\Http\Requests\Revenue\RestoreRequest;
use App\Http\Requests\Revenue\ShowRequest;
use App\Http\Requests\Revenue\UpdateRequest;

class RevenueController extends Controller
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
