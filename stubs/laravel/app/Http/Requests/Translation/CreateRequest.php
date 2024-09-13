<?php

namespace App\Http\Requests\Translation;

use App\Http\Events\Translation\Events\CreateEvent;
use App\Http\Resources\Models\TranslationResource;
use App\Models\Translation;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {

        return $this->user()->can('create', Translation::class);

    }

    public function rules()
    {
        return [
            'language_id' => 'required|integer|exists:languages,id',
            'map' => 'required',
            'translationable_id' => 'required|integer',
            'translationable_type' => 'required|string|max:255',
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

        $translation = (new Translation)->createModel($this);

        $response = new TranslationResource($translation);

        event(new CreateEvent($translation, $this->all(), $response));

        return $response;

    }
}
