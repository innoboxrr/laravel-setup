<?php

namespace App\Http\Requests\Permission;

use App\Models\Permission;
use App\Http\Resources\Models\PermissionResource;
use App\Http\Events\Permission\Events\DeleteEvent;
use Illuminate\Foundation\Http\FormRequest;

class DeleteRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {
        
        $permission = Permission::findOrFail($this->permission_id);

        return $this->user()->can('delete', $permission);

    }

    public function rules()
    {
        return [
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

        $permission->deleteModel();

        $response = new PermissionResource($permission);

        event(new DeleteEvent($permission, $this->all(), $response));

        return $response;

    }
    
}
