<?php

namespace App\Http\Controllers;

use App\Http\Requests\Theory\CreateRequest;
use App\Http\Requests\Theory\DeleteRequest;
use App\Http\Requests\Theory\ExportRequest;
use App\Http\Requests\Theory\ForceDeleteRequest;
use App\Http\Requests\Theory\IndexRequest;
use App\Http\Requests\Theory\PoliciesRequest;
use App\Http\Requests\Theory\PolicyRequest;
use App\Http\Requests\Theory\RestoreRequest;
use App\Http\Requests\Theory\ShowRequest;
use App\Http\Requests\Theory\UpdateRequest;

class TheoryController extends Controller
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
