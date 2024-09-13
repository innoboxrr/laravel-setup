<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\AssignRoleRequest;
use App\Http\Requests\User\CreateRequest;
use App\Http\Requests\User\DeallocateRoleRequest;
use App\Http\Requests\User\DeleteRequest;
use App\Http\Requests\User\ExportRequest;
use App\Http\Requests\User\ForceDeleteRequest;
use App\Http\Requests\User\IndexRequest;
use App\Http\Requests\User\PoliciesRequest;
use App\Http\Requests\User\PolicyRequest;
use App\Http\Requests\User\RestoreRequest;
use App\Http\Requests\User\ShowRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Requests\User\LogoutOtherDevicesRequest;
use App\Http\Requests\User\DeleteAccountRequest;
use App\Http\Requests\User\SendOTPRequest;
use App\Http\Requests\User\VerifyOTPRequest;
use App\Http\Requests\User\SendDirectResetPasswordLinkRequest;
use App\Http\Requests\User\DirectResetPasswordLinkRequest;
use App\Http\Requests\User\AssignBenefitRequest;
use App\Http\Requests\User\DeallocateBenefitRequest;
use App\Http\Requests\User\VerifyEamilRequest;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show', 'verifyOTP', 'directResetPasswordLink']);
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

    public function assignRole(AssignRoleRequest $request)
    {
        return $request->handle();
    }

    public function deallocateRole(DeallocateRoleRequest $request)
    {
        return $request->handle();
    }

    public function logoutOtherDevices(LogoutOtherDevicesRequest $request)
    {
        return $request->handle();
    }

    public function deleteAccount(DeleteAccountRequest $request)
    {
        return $request->handle();
    }

    public function sendOTP(SendOTPRequest $request)
    {
        return $request->handle();
    }

    public function verifyOTP(VerifyOTPRequest $request)
    {
        return $request->handle();
    }

    public function sendDirectResetPasswordLink(SendDirectResetPasswordLinkRequest $request)
    {
        return $request->handle();
    }

    public function directResetPasswordLink(DirectResetPasswordLinkRequest $request)
    {
        return $request->handle();
    }

    public function assignBenefit(AssignBenefitRequest $request)
    {
        return $request->handle();
    }

    public function deallocateBenefit(DeallocateBenefitRequest $request)
    {
        return $request->handle();
    }

    public function verifyEmail(VerifyEamilRequest $request)
    {
        return $request->handle();
    }
}
