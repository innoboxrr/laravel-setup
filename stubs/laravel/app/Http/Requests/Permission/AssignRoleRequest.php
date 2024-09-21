<?php

namespace App\Http\Requests\Permission;

// use App\Http\Events\Permission\Events\AssignRoleEvent;
use App\Models\Permission;
use Illuminate\Foundation\Http\FormRequest;

class AssignRoleRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {

        $permission = Permission::findOrFail($this->permission_id);

        return $this->user()->can('assignRole', $permission);

    }

    public function rules()
    {

        return [
            'permission_id' => 'required|numeric|exists:permissions,id',
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

        $permission = Permission::findOrFail($this->permission_id);

        $response = $permission->assignRole($this);

        // event(new AssignRoleEvent($permission, $this->all(), $response));

        return $response;

    }
}
