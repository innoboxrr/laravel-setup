<?php

namespace App\Http\Requests\User;

use App\Http\Resources\Models\UserResource;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class VerifyEamilRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {
        $user = User::findOrFail($this->user_id);
        return $this->user()->can('verifyEmail', $user);
    }

    public function rules()
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
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
        $user = User::findOrFail($this->user_id);
        $user->email_verified_at = now();
        $user->save();
        return new UserResource($user);
    }
}
