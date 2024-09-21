<?php

namespace App\Http\Controllers;

use App\Http\Requests\Lecture\CreateRequest;
use App\Http\Requests\Lecture\DeleteRequest;
use App\Http\Requests\Lecture\ExportRequest;
use App\Http\Requests\Lecture\ForceDeleteRequest;
use App\Http\Requests\Lecture\IndexRequest;
use App\Http\Requests\Lecture\PoliciesRequest;
use App\Http\Requests\Lecture\PolicyRequest;
use App\Http\Requests\Lecture\RestoreRequest;
use App\Http\Requests\Lecture\ShowRequest;
use App\Http\Requests\Lecture\UpdateRequest;

class LectureController extends Controller
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
