<?php

namespace App\Http\Controllers;

use App\Http\Requests\Quizzable\CreateRequest;
use App\Http\Requests\Quizzable\DeleteRequest;
use App\Http\Requests\Quizzable\ExportRequest;
use App\Http\Requests\Quizzable\ForceDeleteRequest;
use App\Http\Requests\Quizzable\IndexRequest;
use App\Http\Requests\Quizzable\PoliciesRequest;
use App\Http\Requests\Quizzable\PolicyRequest;
use App\Http\Requests\Quizzable\RestoreRequest;
use App\Http\Requests\Quizzable\ShowRequest;
use App\Http\Requests\Quizzable\UpdateRequest;

class QuizzableController extends Controller
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
