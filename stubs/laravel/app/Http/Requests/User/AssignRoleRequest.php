<?php

namespace App\Http\Requests\User;

use App\Http\Events\User\Events\AssignRoleEvent;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class AssignRoleRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {

        $user = User::findOrFail($this->user_id);

        return $this->user()->can('assignRole', $user);

    }

    public function rules()
    {

        return [
            'user_id' => 'required|numeric|exists:users,id',
            'role_id' => 'required|numeric|exists:roles,id',
        ];

    }

    public function messages()
    {
        return [];
    }

    public function attributes()
    {
        return [];
    }

    protected function passedValidation()
    {
        //
    }

    public function handle()
    {

        $user = User::findOrFail($this->user_id);

        $response = $user->assignRole($this);

        event(new AssignRoleEvent($user, $this->all(), $response));

        return $response;

    }
}
