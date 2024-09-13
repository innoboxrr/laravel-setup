<?php

namespace App\Http\Requests\Permission;

use App\Models\Permission;
use App\Http\Resources\Models\PermissionResource;
use App\Http\Events\Permission\Events\CreateEvent;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {

        return $this->user()->can('create', Permission::class);

    }

    public function rules()
    {
        return [
            //
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

        $permission = (new Permission)->createModel($this);

        $response = new PermissionResource($permission);

        event(new CreateEvent($permission, $this->all(), $response));

        return $response;

    }
    
}
