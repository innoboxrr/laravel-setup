<?php

namespace App\Http\Requests\Translation;

use App\Http\Events\Translation\Events\UpdateEvent;
use App\Http\Resources\Models\TranslationResource;
use App\Models\Translation;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {

        $translation = Translation::findOrFail($this->translation_id);

        return $this->user()->can('update', $translation);

    }

    public function rules()
    {
        return [
            'map' => 'required',
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

        $translation = Translation::findOrFail($this->translation_id);

        $translation = $translation->updateModel($this);

        $response = new TranslationResource($translation);

        event(new UpdateEvent($translation, $this->all(), $response));

        return $response;

    }
}
