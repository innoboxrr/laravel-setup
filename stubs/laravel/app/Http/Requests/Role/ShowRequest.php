<?php

namespace App\Http\Requests\Role;

use App\Http\Resources\Models\RoleResource;
use App\Models\Role;
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

        $role = Role::findOrFail($this->role_id);

        return $this->user()->can('view', $role);

    }

    public function rules()
    {
        return [
            'load_relations' => [
                'nullable',
                'array',
                Rule::in(Role::$loadable_relations),
            ],
            'load_counts' => [
                'nullable',
                'array',
                Rule::in(Role::$loadable_counts),
            ],
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

        $role = Role::where('id', $this->role_id)
            ->with($this->load_relations ?? [])
            ->withCount($this->load_counts ?? [])
            ->firstOrFail();

        return new RoleResource($role);

    }
}
