<?php

namespace App\Http\Requests\Translation;

use App\Http\Resources\Models\TranslationResource;
use App\Models\Translation;
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

        $translation = Translation::findOrFail($this->translation_id);

        return $this->user()->can('view', $translation);

    }

    public function rules()
    {
        return [
            'load_relations' => [
                'nullable',
                'array',
                Rule::in(Translation::$loadable_relations),
            ],
            'load_counts' => [
                'nullable',
                'array',
                Rule::in(Translation::$loadable_counts),
            ],
            'translation_id' => 'required|numeric',
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

        $translation = Translation::where('id', $this->translation_id)
            ->with($this->load_relations ?? [])
            ->withCount($this->load_counts ?? [])
            ->firstOrFail();

        return new TranslationResource($translation);

    }
}
