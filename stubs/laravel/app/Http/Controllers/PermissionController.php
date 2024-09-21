<?php

namespace App\Http\Controllers;

use App\Http\Requests\Permission\PoliciesRequest;
use App\Http\Requests\Permission\PolicyRequest;
use App\Http\Requests\Permission\IndexRequest;
use App\Http\Requests\Permission\ShowRequest;
use App\Http\Requests\Permission\CreateRequest;
use App\Http\Requests\Permission\UpdateRequest;
use App\Http\Requests\Permission\DeleteRequest;
use App\Http\Requests\Permission\RestoreRequest;
use App\Http\Requests\Permission\ForceDeleteRequest;
use App\Http\Requests\Permission\ExportRequest;
use App\Http\Requests\Permission\AssignRoleRequest;
use App\Http\Requests\Permission\DeallocateRoleRequest;
use App\Http\Requests\Permission\AssignUserRequest;
use App\Http\Requests\Permission\DeallocateUserRequest;

class PermissionController extends Controller
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

    public function assignRole(AssignRoleRequest $request)
    {
        return $request->handle();   
    }

    public function deallocateRole(DeallocateRoleRequest $request)
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
