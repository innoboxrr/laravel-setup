<?php

namespace App\Http\Requests\User;

use App\Http\Resources\Models\UserResource;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class DirectResetPasswordLinkRequest extends FormRequest
{

    protected $user;

    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {
        try {
            $this->user = User::findOrFail(decrypt($this->token));
        } catch (\Exception $e) {
            return false;
        }
        if ($this->user->email !== $this->email) {
            return false;
        }
        return true;
    }

    public function rules()
    {
        return [
            'password' => 'required|string|min:8|max:255|confirmed',
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
        $response = $this->user->directResetPasswordLink($this->password);
        $response = new UserResource($this->user);
        return $response;
    }
}
