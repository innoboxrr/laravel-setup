<?php

namespace App\Http\Controllers;

use App\Http\Requests\WishlistItem\CreateRequest;
use App\Http\Requests\WishlistItem\DeleteRequest;
use App\Http\Requests\WishlistItem\ExportRequest;
use App\Http\Requests\WishlistItem\ForceDeleteRequest;
use App\Http\Requests\WishlistItem\IndexRequest;
use App\Http\Requests\WishlistItem\PoliciesRequest;
use App\Http\Requests\WishlistItem\PolicyRequest;
use App\Http\Requests\WishlistItem\RestoreRequest;
use App\Http\Requests\WishlistItem\ShowRequest;
use App\Http\Requests\WishlistItem\UpdateRequest;

class WishlistItemController extends Controller
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
