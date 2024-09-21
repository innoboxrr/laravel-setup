<?php

namespace App\Http\Requests\Permission;

use App\Models\Permission;
use App\Http\Resources\Models\PermissionResource;
use App\Http\Events\Permission\Events\ForceDeleteEvent;
use Illuminate\Foundation\Http\FormRequest;

class ForceDeleteRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {

        $permission = Permission::withTrashed()->findOrFail($this->permission_id);
        
        return $this->user()->can('forceDelete', $permission);

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

        $permission = Permission::withTrashed()->findOrFail($this->permission_id);

        $permission->forceDeleteModel();

        $response = new PermissionResource($permission);

        event(new ForceDeleteEvent($permission, $this->all(), $response));

        return $response;

    }
    
}
