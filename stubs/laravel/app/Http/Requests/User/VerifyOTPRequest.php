<?php

namespace App\Http\Requests\User;

use App\Http\Resources\Models\UserResource;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class VerifyOTPRequest extends FormRequest
{

    protected $user;

    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'otp' => 'required|integer|min:100000|max:999999',
            'token' => [
                'required', 
                'string',
                function ($attribute, $value, $fail) {
                    try {
                        $this->user = User::findOrFail(decrypt($value));
                    } catch (\Exception $e) {
                        $fail('The token is invalid.');
                    }
                },
            ],
        ];
    }

    public function messages()
    {
        return [
            //
        ];
    }

    public function attributes()
    {
        return [
            //
        ];
    }

    protected function passedValidation()
    {
        //
    }

    public function handle()
    {
        $response = $this->user->verifyOTP($this->otp);
        $response = new UserResource($this->user);
        Auth::login($this->user);
        return $response;
    }
}
