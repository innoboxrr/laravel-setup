<?php

namespace App\Http\Controllers;

use App\Http\Requests\Testkin\CreateRequest;
use App\Http\Requests\Testkin\DeleteRequest;
use App\Http\Requests\Testkin\ExportRequest;
use App\Http\Requests\Testkin\ForceDeleteRequest;
use App\Http\Requests\Testkin\IndexRequest;
use App\Http\Requests\Testkin\PoliciesRequest;
use App\Http\Requests\Testkin\PolicyRequest;
use App\Http\Requests\Testkin\RestoreRequest;
use App\Http\Requests\Testkin\ShowRequest;
use App\Http\Requests\Testkin\UpdateRequest;
use App\Http\Requests\Testkin\DownloadFullPdfRequest;

class TestkinController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
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

    public function downloadFullPdf(DownloadFullPdfRequest $request)
    {
        return $request->handle();
    }
}
