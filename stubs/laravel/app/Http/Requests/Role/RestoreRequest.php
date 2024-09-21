<?php

namespace App\Http\Requests\Role;

use App\Http\Events\Role\Events\RestoreEvent;
use App\Http\Resources\Models\RoleResource;
use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class RestoreRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {

        $role = Role::withTrashed()->findOrFail($this->role_id);

        return $this->user()->can('restore', $role);

    }

    public function rules()
    {
        return [
            'role_id' => 'required|numeric',
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

        $role = Role::withTrashed()->findOrFail($this->role_id);

        $role->restoreModel();

        $response = new RoleResource($role);

        event(new RestoreEvent($role, $this->all(), $response));

        return $response;

    }
}
