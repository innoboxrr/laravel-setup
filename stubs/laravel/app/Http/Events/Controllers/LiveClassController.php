<?php

namespace App\Http\Controllers;

use App\Http\Requests\LiveClass\CreateRequest;
use App\Http\Requests\LiveClass\DeleteRequest;
use App\Http\Requests\LiveClass\ExportRequest;
use App\Http\Requests\LiveClass\ForceDeleteRequest;
use App\Http\Requests\LiveClass\IndexRequest;
use App\Http\Requests\LiveClass\JoinRequest;
use App\Http\Requests\LiveClass\PoliciesRequest;
use App\Http\Requests\LiveClass\PolicyRequest;
use App\Http\Requests\LiveClass\RestoreRequest;
use App\Http\Requests\LiveClass\ShowRequest;
use App\Http\Requests\LiveClass\UpdateRequest;
use App\Http\Requests\LiveClass\ValidateAuthRequest;

class LiveClassController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['validateAuth']);
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

    public function join(JoinRequest $request)
    {
        return $request->handle();
    }

    public function validateAuth(ValidateAuthRequest $request)
    {
        return $request->handle();
    }
}
