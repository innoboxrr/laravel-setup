<?php

namespace App\Http\Requests\Permission;

// use App\Http\Events\Permission\Events\DeallocateUserEvent;
use App\Models\Permission;
use Illuminate\Foundation\Http\FormRequest;

class DeallocateUserRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {

        $permission = Permission::findOrFail($this->permission_id);

        return $this->user()->can('deallocateUser', $permission);

    }

    public function rules()
    {

        return [
            'user_id' => 'required|numeric|exists:users,id',
            'role_id' => 'required|numeric|exists:roles,id',
            'permission_id' => 'required|numeric|exists:permissions,id',
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

        $permission = Permission::findOrFail($this->permission_id);

        $response = $permission->deallocateUser($this);

        // event(new DeallocateUserEvent($permission, $this->all(), $response));

        return $response;

    }
}
