<?php

namespace App\Http\Controllers;

use App\Http\Requests\Price\CreateRequest;
use App\Http\Requests\Price\DeleteRequest;
use App\Http\Requests\Price\ExportRequest;
use App\Http\Requests\Price\ForceDeleteRequest;
use App\Http\Requests\Price\IndexRequest;
use App\Http\Requests\Price\PoliciesRequest;
use App\Http\Requests\Price\PolicyRequest;
use App\Http\Requests\Price\RestoreRequest;
use App\Http\Requests\Price\ShowRequest;
use App\Http\Requests\Price\UpdateRequest;

class PriceController extends Controller
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
