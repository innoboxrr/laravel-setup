<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class AppController extends Controller
{
    public function app()
    {
        return response()->view('app');
    }

    public function exports($xlsx)
    {
        return Storage::disk('s3')->download("exports/{$xlsx}");
    }
}
