<?php

namespace App\Http\Requests\Translation;

use App\Http\Events\Translation\Events\ForceDeleteEvent;
use App\Http\Resources\Models\TranslationResource;
use App\Models\Translation;
use Illuminate\Foundation\Http\FormRequest;

class ForceDeleteRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {

        $translation = Translation::withTrashed()->findOrFail($this->translation_id);

        return $this->user()->can('forceDelete', $translation);

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

        $translation = Translation::withTrashed()->findOrFail($this->translation_id);

        $translation->forceDeleteModel();

        $response = new TranslationResource($translation);

        event(new ForceDeleteEvent($translation, $this->all(), $response));

        return $response;

    }
}
