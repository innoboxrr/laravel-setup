<?php

namespace App\Http\Controllers;

use App\Http\Requests\Option\CreateRequest;
use App\Http\Requests\Option\DeleteRequest;
use App\Http\Requests\Option\ExportRequest;
use App\Http\Requests\Option\ForceDeleteRequest;
use App\Http\Requests\Option\IndexRequest;
use App\Http\Requests\Option\PoliciesRequest;
use App\Http\Requests\Option\PolicyRequest;
use App\Http\Requests\Option\RestoreRequest;
use App\Http\Requests\Option\ShowRequest;
use App\Http\Requests\Option\UpdateRequest;

class OptionController extends Controller
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
