<?php

namespace App\Http\Controllers;

use App\Http\Requests\Package\CreateRequest;
use App\Http\Requests\Package\DeleteRequest;
use App\Http\Requests\Package\ExportRequest;
use App\Http\Requests\Package\ForceDeleteRequest;
use App\Http\Requests\Package\IndexRequest;
use App\Http\Requests\Package\PoliciesRequest;
use App\Http\Requests\Package\PolicyRequest;
use App\Http\Requests\Package\RestoreRequest;
use App\Http\Requests\Package\ShowRequest;
use App\Http\Requests\Package\UpdateRequest;
use App\Http\Requests\Package\AssignProductRequest;
use App\Http\Requests\Package\DeallocateProductRequest;

class PackageController extends Controller
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

    public function assignProduct(AssignProductRequest $request)
    {
        return $request->handle();
    }

    public function deallocateProduct(DeallocateProductRequest $request)
    {
        return $request->handle();
    }
}
