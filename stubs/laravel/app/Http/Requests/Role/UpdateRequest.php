<?php

namespace App\Http\Requests\Role;

use App\Http\Events\Role\Events\UpdateEvent;
use App\Http\Resources\Models\RoleResource;
use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {

        $role = Role::findOrFail($this->role_id);

        return $this->user()->can('update', $role);

    }

    public function rules()
    {
        return [
            'role_id' => 'required|integer|exists:roles,id',
            'name' => 'nullable|string|max:255|unique:roles,name,role_id',
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

        $role = Role::findOrFail($this->role_id);

        $role = $role->updateModel($this);

        $response = new RoleResource($role);

        event(new UpdateEvent($role, $this->all(), $response));

        return $response;

    }
}
