<?php

namespace App\Http\Requests\Language;

use App\Http\Events\Language\Events\RestoreEvent;
use App\Http\Resources\Models\LanguageResource;
use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;

class RestoreRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {

        $language = Language::withTrashed()->findOrFail($this->language_id);

        return $this->user()->can('restore', $language);

    }

    public function rules()
    {
        return [
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

        $language = Language::withTrashed()->findOrFail($this->language_id);

        $language->restoreModel();

        $response = new LanguageResource($language);

        event(new RestoreEvent($language, $this->all(), $response));

        return $response;

    }
}
