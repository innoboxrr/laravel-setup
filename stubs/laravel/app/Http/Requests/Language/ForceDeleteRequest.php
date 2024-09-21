<?php

namespace App\Http\Requests\Language;

use App\Http\Events\Language\Events\ForceDeleteEvent;
use App\Http\Resources\Models\LanguageResource;
use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;

class ForceDeleteRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {

        $language = Language::withTrashed()->findOrFail($this->language_id);

        return $this->user()->can('forceDelete', $language);

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

        $language->forceDeleteModel();

        $response = new LanguageResource($language);

        event(new ForceDeleteEvent($language, $this->all(), $response));

        return $response;

    }
}
