<?php

namespace App\Http\Requests\Role;

use App\Http\Events\Role\Events\DeallocateUserEvent;
use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class DeallocateUserRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {

        $role = Role::findOrFail($this->role_id);

        return $this->user()->can('deallocateUser', $role);

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

        $role = Role::findOrFail($this->role_id);

        $response = $role->deallocateUser($this);

        event(new DeallocateUserEvent($role, $this->all(), $response));

        return $response;

    }
}
