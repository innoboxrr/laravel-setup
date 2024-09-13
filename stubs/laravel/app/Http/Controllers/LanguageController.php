<?php

namespace App\Http\Controllers;

use App\Http\Requests\Language\CreateRequest;
use App\Http\Requests\Language\DeleteRequest;
use App\Http\Requests\Language\ExportRequest;
use App\Http\Requests\Language\ForceDeleteRequest;
use App\Http\Requests\Language\IndexRequest;
use App\Http\Requests\Language\PoliciesRequest;
use App\Http\Requests\Language\PolicyRequest;
use App\Http\Requests\Language\RestoreRequest;
use App\Http\Requests\Language\ShowRequest;
use App\Http\Requests\Language\UpdateRequest;
use App\Http\Requests\Language\UserRequest;
use App\Http\Requests\Language\SetRequest;
use App\Http\Requests\Language\GetJsonRequest;
use App\Http\Requests\Language\UpdateJsonRequest;

class LanguageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show', 'user', 'set']);
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

    public function user(UserRequest $request)
    {
        return $request->handle();
    }

    public function set(SetRequest $request)
    {
        return $request->handle();
    }

    public function getJson(GetJsonRequest $request)
    {
        return $request->handle();
    }

    public function updateJson(UpdateJsonRequest $request)
    {
        return $request->handle();
    }
}
