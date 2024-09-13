<?php

namespace App\Http\Requests\Role;

use App\Http\Events\Role\Events\CreateEvent;
use App\Http\Resources\Models\RoleResource;
use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {

        return $this->user()->can('create', Role::class);

    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:roles,name',
            'slug' => 'required|string|max:255|unique:roles,slug',
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

        $role = (new Role)->createModel($this);

        $response = new RoleResource($role);

        event(new CreateEvent($role, $this->all(), $response));

        return $response;

    }
}
