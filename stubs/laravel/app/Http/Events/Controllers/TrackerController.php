<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tracker\CreateRequest;
use App\Http\Requests\Tracker\DeleteRequest;
use App\Http\Requests\Tracker\ExportRequest;
use App\Http\Requests\Tracker\ForceDeleteRequest;
use App\Http\Requests\Tracker\IndexRequest;
use App\Http\Requests\Tracker\PoliciesRequest;
use App\Http\Requests\Tracker\PolicyRequest;
use App\Http\Requests\Tracker\RestoreRequest;
use App\Http\Requests\Tracker\ShowRequest;
use App\Http\Requests\Tracker\UpdateRequest;

class TrackerController extends Controller
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
