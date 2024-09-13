<?php

namespace App\Http\Controllers;

use App\Http\Requests\Subtitle\CreateRequest;
use App\Http\Requests\Subtitle\DeleteRequest;
use App\Http\Requests\Subtitle\ExportRequest;
use App\Http\Requests\Subtitle\ForceDeleteRequest;
use App\Http\Requests\Subtitle\IndexRequest;
use App\Http\Requests\Subtitle\PoliciesRequest;
use App\Http\Requests\Subtitle\PolicyRequest;
use App\Http\Requests\Subtitle\RestoreRequest;
use App\Http\Requests\Subtitle\ShowRequest;
use App\Http\Requests\Subtitle\UpdateRequest;

class SubtitleController extends Controller
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
