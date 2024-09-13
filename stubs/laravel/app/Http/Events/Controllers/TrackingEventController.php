<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrackingEvent\PoliciesRequest;
use App\Http\Requests\TrackingEvent\PolicyRequest;
use App\Http\Requests\TrackingEvent\IndexRequest;
use App\Http\Requests\TrackingEvent\ShowRequest;
use App\Http\Requests\TrackingEvent\CreateRequest;
use App\Http\Requests\TrackingEvent\UpdateRequest;
use App\Http\Requests\TrackingEvent\DeleteRequest;
use App\Http\Requests\TrackingEvent\RestoreRequest;
use App\Http\Requests\TrackingEvent\ForceDeleteRequest;
use App\Http\Requests\TrackingEvent\ExportRequest;

class TrackingEventController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['create']);
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
