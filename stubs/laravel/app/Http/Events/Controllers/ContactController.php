<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\PoliciesRequest;
use App\Http\Requests\Contact\PolicyRequest;
use App\Http\Requests\Contact\IndexRequest;
use App\Http\Requests\Contact\ShowRequest;
use App\Http\Requests\Contact\CreateRequest;
use App\Http\Requests\Contact\UpdateRequest;
use App\Http\Requests\Contact\DeleteRequest;
use App\Http\Requests\Contact\RestoreRequest;
use App\Http\Requests\Contact\ForceDeleteRequest;
use App\Http\Requests\Contact\ExportRequest;

class ContactController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('create');
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