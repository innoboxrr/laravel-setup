<?php

namespace App\Http\Requests\Option;

use App\Http\Resources\Models\OptionResource;
use App\Models\Option;
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

        $option = Option::findOrFail($this->option_id);

        return $this->user()->can('view', $option);

    }

    public function rules()
    {
        return [
            'load_relations' => [
                'nullable',
                'array',
                Rule::in(Option::$loadable_relations),
            ],
            'load_counts' => [
                'nullable',
                'array',
                Rule::in(Option::$loadable_counts),
            ],
            'option_id' => 'required|numeric',
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

        $option = Option::where('id', $this->option_id)
            ->with($this->load_relations ?? [])
            ->withCount($this->load_counts ?? [])
            ->firstOrFail();

        return new OptionResource($option);

    }
}
