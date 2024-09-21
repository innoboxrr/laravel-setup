<?php

namespace App\Http\Controllers;

use App\Http\Requests\Attendance\CreateRequest;
use App\Http\Requests\Attendance\DeleteRequest;
use App\Http\Requests\Attendance\ExportRequest;
use App\Http\Requests\Attendance\ForceDeleteRequest;
use App\Http\Requests\Attendance\IndexRequest;
use App\Http\Requests\Attendance\PoliciesRequest;
use App\Http\Requests\Attendance\PolicyRequest;
use App\Http\Requests\Attendance\RestoreRequest;
use App\Http\Requests\Attendance\ShowRequest;
use App\Http\Requests\Attendance\UpdateRequest;

class AttendanceController extends Controller
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
