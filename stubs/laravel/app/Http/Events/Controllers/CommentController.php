<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\CreateRequest;
use App\Http\Requests\Comment\DeleteRequest;
use App\Http\Requests\Comment\ExportRequest;
use App\Http\Requests\Comment\ForceDeleteRequest;
use App\Http\Requests\Comment\IndexRequest;
use App\Http\Requests\Comment\PoliciesRequest;
use App\Http\Requests\Comment\PolicyRequest;
use App\Http\Requests\Comment\RestoreRequest;
use App\Http\Requests\Comment\ShowRequest;
use App\Http\Requests\Comment\UpdateRequest;

class CommentController extends Controller
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
