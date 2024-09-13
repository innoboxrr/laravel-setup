<?php

namespace App\Http\Requests\Permission;

use App\Models\Permission;
use App\Http\Resources\Models\PermissionResource;
use App\Http\Events\Permission\Events\UpdateEvent;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {
        
        $permission = Permission::findOrFail($this->permission_id);

        return $this->user()->can('update', $permission);

    }

    public function rules()
    {
        return [
            //
            'permission_id' => 'required|numeric'
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

        $permission = Permission::findOrFail($this->permission_id);

        $permission = $permission->updateModel($this);

        $response = new PermissionResource($permission);

        event(new UpdateEvent($permission, $this->all(), $response));

        return $response;

    }

}
