<?php

namespace App\Http\Requests\Role;

use App\Http\Events\Role\Events\AssignUserEvent;
use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class AssignUserRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {

        $role = Role::findOrFail($this->role_id);

        return $this->user()->can('assignUser', $role);

    }

    public function rules()
    {

        return [
            'role_id' => 'required|numeric|exists:roles,id',
            'user_id' => 'required|numeric|exists:users,id',
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

        $role = Role::findOrFail($this->role_id);

        $response = $role->assignUser($this);

        event(new AssignUserEvent($role, $this->all(), $response));

        return $response;

    }
}
