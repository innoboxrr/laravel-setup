<?php

namespace App\Http\Requests\Role;

use App\Http\Events\Role\Events\DeleteEvent;
use App\Http\Resources\Models\RoleResource;
use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class DeleteRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {

        $role = Role::findOrFail($this->role_id);

        return $this->user()->can('delete', $role);

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

        $role = Role::findOrFail($this->role_id);

        $role->deleteModel();

        $response = new RoleResource($role);

        event(new DeleteEvent($role, $this->all(), $response));

        return $response;

    }
}
