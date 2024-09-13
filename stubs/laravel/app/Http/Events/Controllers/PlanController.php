<?php

namespace App\Http\Controllers;

use App\Http\Requests\Plan\PoliciesRequest;
use App\Http\Requests\Plan\PolicyRequest;
use App\Http\Requests\Plan\IndexRequest;
use App\Http\Requests\Plan\ShowRequest;
use App\Http\Requests\Plan\CreateRequest;
use App\Http\Requests\Plan\UpdateRequest;
use App\Http\Requests\Plan\DeleteRequest;
use App\Http\Requests\Plan\RestoreRequest;
use App\Http\Requests\Plan\ForceDeleteRequest;
use App\Http\Requests\Plan\ExportRequest;

class PlanController extends Controller
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
