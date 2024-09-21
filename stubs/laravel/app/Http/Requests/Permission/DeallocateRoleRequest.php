<?php

namespace App\Http\Requests\Permission;

// use App\Http\Events\Permission\Events\DeallocateRoleEvent;
use App\Models\Permission;
use Illuminate\Foundation\Http\FormRequest;

class DeallocateRoleRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {

        $permission = Permission::findOrFail($this->permission_id);

        return $this->user()->can('deallocateRole', $permission);

    }

    public function rules()
    {

        return [
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

        $response = $permission->deallocateRole($this);

        // event(new DeallocateRoleEvent($permission, $this->all(), $response));

        return $response;

    }
}
