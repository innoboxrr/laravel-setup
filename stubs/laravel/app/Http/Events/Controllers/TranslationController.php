<?php

namespace App\Http\Controllers;

use App\Http\Requests\Translation\CreateRequest;
use App\Http\Requests\Translation\DeleteRequest;
use App\Http\Requests\Translation\ExportRequest;
use App\Http\Requests\Translation\ForceDeleteRequest;
use App\Http\Requests\Translation\IndexRequest;
use App\Http\Requests\Translation\PoliciesRequest;
use App\Http\Requests\Translation\PolicyRequest;
use App\Http\Requests\Translation\RestoreRequest;
use App\Http\Requests\Translation\ShowRequest;
use App\Http\Requests\Translation\UpdateRequest;

class TranslationController extends Controller
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
