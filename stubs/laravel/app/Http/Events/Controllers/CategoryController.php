<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CreateRequest;
use App\Http\Requests\Category\DeleteRequest;
use App\Http\Requests\Category\ExportRequest;
use App\Http\Requests\Category\ForceDeleteRequest;
use App\Http\Requests\Category\IndexRequest;
use App\Http\Requests\Category\PoliciesRequest;
use App\Http\Requests\Category\PolicyRequest;
use App\Http\Requests\Category\RestoreRequest;
use App\Http\Requests\Category\ShowRequest;
use App\Http\Requests\Category\SyncRequest;
use App\Http\Requests\Category\UpdateRequest;

class CategoryController extends Controller
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

    public function sync(SyncRequest $request)
    {
        return $request->handle();
    }
}
