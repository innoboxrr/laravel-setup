<?php

namespace App\Http\Requests\Translation;

use App\Http\Events\Translation\Events\DeleteEvent;
use App\Http\Resources\Models\TranslationResource;
use App\Models\Translation;
use Illuminate\Foundation\Http\FormRequest;

class DeleteRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {

        $translation = Translation::findOrFail($this->translation_id);

        return $this->user()->can('delete', $translation);

    }

    public function rules()
    {
        return [
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

        $translation->deleteModel();

        $response = new TranslationResource($translation);

        event(new DeleteEvent($translation, $this->all(), $response));

        return $response;

    }
}
