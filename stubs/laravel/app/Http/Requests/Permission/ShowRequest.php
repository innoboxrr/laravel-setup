<?php

namespace App\Http\Requests\Permission;

use App\Models\Permission;
use App\Http\Resources\Models\PermissionResource;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShowRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {

        $permission = Permission::findOrFail($this->permission_id);

        return $this->user()->can('view', $permission);

    }

    public function rules()
    {
        return [
            'load_relations' => [
                'nullable',
                'array',
                Rule::in(Permission::$loadable_relations)
            ],
            'load_counts' => [
                'nullable',
                'array',
                Rule::in(Permission::$loadable_counts)
            ],
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

        $permission = Permission::where('id', $this->permission_id)
            ->with($this->load_relations ?? [])
            ->withCount($this->load_counts ?? [])
            ->firstOrFail();

        return new PermissionResource($permission);

    }
    
}
