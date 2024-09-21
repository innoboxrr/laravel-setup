<?php

namespace App\Http\Requests\User;

use App\Http\Resources\Models\UserResource;
use App\Models\User;
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
        if(!auth()->check()) {
            return true;
        }
        $user = User::findOrFail($this->user_id);

        return $this->user()->can('view', $user);

    }

    public function rules()
    {
        return [
            'load_relations' => [
                'nullable',
                'array',
                Rule::in(User::$loadable_relations),
            ],
            'load_counts' => [
                'nullable',
                'array',
                Rule::in(User::$loadable_counts),
            ],
            'user_id' => 'required|numeric',
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

        $user = User::where('id', $this->user_id)
            ->with($this->load_relations ?? [])
            ->withCount($this->load_counts ?? [])
            ->firstOrFail();

        return new UserResource($user);

    }
}
