<?php

namespace App\Http\Requests\User;

use App\Http\Events\User\Events\SendOtpEvent;
use App\Http\Resources\Models\UserResource;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class SendOTPRequest extends FormRequest
{

    protected $user;

    protected function prepareForValidation()
    {
        $this->merge([
            'minutes' => $this->minutes ?? 5,
        ]);
    }

    public function authorize()
    {
        if(!auth()->check()) {
            return false;
        }
        $this->user = User::findOrFail($this->user_id);
        return $this->user()->can('sendOtp', $this->user);
    }

    public function rules()
    {
        return [
            'minutes' => 'required|integer|min:1|max:600000',
            'user_id' => 'required|integer',
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

    }

    public function handle()
    {
        $this->user->sendOtpModel($this->minutes);
        $response = new UserResource($this->user);
        event(new SendOtpEvent($this->user, $this->all(), $response));
        return $response;
    }
}
