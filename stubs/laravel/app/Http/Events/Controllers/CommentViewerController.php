<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentViewer\CreateRequest;
use App\Http\Requests\CommentViewer\DeleteRequest;
use App\Http\Requests\CommentViewer\ExportRequest;
use App\Http\Requests\CommentViewer\ForceDeleteRequest;
use App\Http\Requests\CommentViewer\IndexRequest;
use App\Http\Requests\CommentViewer\PoliciesRequest;
use App\Http\Requests\CommentViewer\PolicyRequest;
use App\Http\Requests\CommentViewer\RestoreRequest;
use App\Http\Requests\CommentViewer\ShowRequest;
use App\Http\Requests\CommentViewer\UpdateRequest;

class CommentViewerController extends Controller
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
