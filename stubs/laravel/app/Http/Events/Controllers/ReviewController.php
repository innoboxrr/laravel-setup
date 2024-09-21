<?php

namespace App\Http\Controllers;

use App\Http\Requests\Review\CreateRequest;
use App\Http\Requests\Review\DeleteRequest;
use App\Http\Requests\Review\ExportRequest;
use App\Http\Requests\Review\ForceDeleteRequest;
use App\Http\Requests\Review\IndexRequest;
use App\Http\Requests\Review\PoliciesRequest;
use App\Http\Requests\Review\PolicyRequest;
use App\Http\Requests\Review\RestoreRequest;
use App\Http\Requests\Review\ShowRequest;
use App\Http\Requests\Review\UpdateRequest;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index']);
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
