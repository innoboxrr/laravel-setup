<?php

namespace App\Http\Controllers;

use App\Http\Requests\Benefit\CreateRequest;
use App\Http\Requests\Benefit\DeleteRequest;
use App\Http\Requests\Benefit\ExportRequest;
use App\Http\Requests\Benefit\ForceDeleteRequest;
use App\Http\Requests\Benefit\IndexRequest;
use App\Http\Requests\Benefit\PoliciesRequest;
use App\Http\Requests\Benefit\PolicyRequest;
use App\Http\Requests\Benefit\RestoreRequest;
use App\Http\Requests\Benefit\ShowRequest;
use App\Http\Requests\Benefit\UpdateRequest;

class BenefitController extends Controller
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
