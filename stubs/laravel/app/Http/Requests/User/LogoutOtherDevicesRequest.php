<?php

namespace App\Http\Requests\User;

use App\Http\Events\User\Events\LogoutOtherDevicesEvent;
use App\Http\Resources\Models\UserResource;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class LogoutOtherDevicesRequest extends FormRequest
{

    protected $user;

    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {
        $this->user = User::findOrFail($this->user_id);
        return $this->user()->can('logoutOtherDevices', $this->user);
    }

    public function rules()
    {
        return [
            'password' => 'required|string',
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
        $this->user->logoutOtherDevicesModel();
        $response = new UserResource($this->user);
        event(new LogoutOtherDevicesEvent($this->user, $this->all(), $response));
        return $response;
    }
}
