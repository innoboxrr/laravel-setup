<?php

namespace App\Http\Requests\Language;

use App\Http\Events\Language\Events\UpdateEvent;
use App\Http\Resources\Models\LanguageResource;
use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {

        $language = Language::findOrFail($this->language_id);

        return $this->user()->can('update', $language);

    }

    public function rules()
    {
        return [
            'language_id' => 'required|integer|exists:languages,id',
            'name' => 'nullable|string|max:255|unique:languages,name,language_id',
            'code' => 'nullable|string|max:10|unique:languages,code,language_id',
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

        $language = Language::findOrFail($this->language_id);

        $language = $language->updateModel($this);

        $response = new LanguageResource($language);

        event(new UpdateEvent($language, $this->all(), $response));

        return $response;

    }
}
