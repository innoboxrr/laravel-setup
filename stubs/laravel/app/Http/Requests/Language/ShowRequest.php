<?php

namespace App\Http\Requests\Language;

use App\Http\Resources\Models\LanguageResource;
use App\Models\Language;
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

        $language = Language::findOrFail($this->language_id);

        return $this->user()->can('view', $language);

    }

    public function rules()
    {
        return [
            'load_relations' => [
                'nullable',
                'array',
                Rule::in(Language::$loadable_relations),
            ],
            'load_counts' => [
                'nullable',
                'array',
                Rule::in(Language::$loadable_counts),
            ],
            'language_id' => 'required|numeric',
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

        $language = Language::where('id', $this->language_id)
            ->with($this->load_relations ?? [])
            ->withCount($this->load_counts ?? [])
            ->firstOrFail();

        return new LanguageResource($language);

    }
}
