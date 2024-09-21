<?php

namespace App\Http\Controllers;

use App\Http\Requests\Wishlist\CreateRequest;
use App\Http\Requests\Wishlist\DeleteRequest;
use App\Http\Requests\Wishlist\ExportRequest;
use App\Http\Requests\Wishlist\ForceDeleteRequest;
use App\Http\Requests\Wishlist\IndexRequest;
use App\Http\Requests\Wishlist\PoliciesRequest;
use App\Http\Requests\Wishlist\PolicyRequest;
use App\Http\Requests\Wishlist\RestoreRequest;
use App\Http\Requests\Wishlist\ShowRequest;
use App\Http\Requests\Wishlist\UpdateRequest;

class WishlistController extends Controller
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
