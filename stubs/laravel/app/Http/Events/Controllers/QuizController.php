<?php

namespace App\Http\Controllers;

use App\Http\Requests\Quiz\AssignCourseRequest;
use App\Http\Requests\Quiz\CreateRequest;
use App\Http\Requests\Quiz\DeallocateCourseRequest;
use App\Http\Requests\Quiz\DeleteRequest;
use App\Http\Requests\Quiz\ExportRequest;
use App\Http\Requests\Quiz\ForceDeleteRequest;
use App\Http\Requests\Quiz\IndexRequest;
use App\Http\Requests\Quiz\PoliciesRequest;
use App\Http\Requests\Quiz\PolicyRequest;
use App\Http\Requests\Quiz\RestoreRequest;
use App\Http\Requests\Quiz\ShowRequest;
use App\Http\Requests\Quiz\SortQuestionsRequest;
use App\Http\Requests\Quiz\UpdateRequest;

class QuizController extends Controller
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

    public function sortQuestions(SortQuestionsRequest $request)
    {
        return $request->handle();
    }

    public function assignCourse(AssignCourseRequest $request)
    {
        return $request->handle();
    }

    public function deallocateCourse(DeallocateCourseRequest $request)
    {
        return $request->handle();
    }
}
