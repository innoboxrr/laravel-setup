<?php

namespace App\Http\Requests\Role;

use App\Http\Events\Role\Events\ForceDeleteEvent;
use App\Http\Resources\Models\RoleResource;
use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class ForceDeleteRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {

        $role = Role::withTrashed()->findOrFail($this->role_id);

        return $this->user()->can('forceDelete', $role);

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

        $role->forceDeleteModel();

        $response = new RoleResource($role);

        event(new ForceDeleteEvent($role, $this->all(), $response));

        return $response;

    }
}
