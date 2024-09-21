<?php

namespace App\Http\Controllers;

use App\Http\Requests\Role\AssignUserRequest;
use App\Http\Requests\Role\CreateRequest;
use App\Http\Requests\Role\DeallocateUserRequest;
use App\Http\Requests\Role\DeleteRequest;
use App\Http\Requests\Role\ExportRequest;
use App\Http\Requests\Role\ForceDeleteRequest;
use App\Http\Requests\Role\IndexRequest;
use App\Http\Requests\Role\PoliciesRequest;
use App\Http\Requests\Role\PolicyRequest;
use App\Http\Requests\Role\RestoreRequest;
use App\Http\Requests\Role\ShowRequest;
use App\Http\Requests\Role\UpdateRequest;

class RoleController extends Controller
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

    public function assignUser(AssignUserRequest $request)
    {
        return $request->handle();
    }

    public function deallocateUser(DeallocateUserRequest $request)
    {
        return $request->handle();
    }
}
