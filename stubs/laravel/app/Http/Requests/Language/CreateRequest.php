<?php

namespace App\Http\Requests\Language;

use App\Http\Events\Language\Events\CreateEvent;
use App\Http\Resources\Models\LanguageResource;
use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {

        return $this->user()->can('create', Language::class);

    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:languages,name',
            'code' => 'required|string|max:10|unique:languages,code',
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

        $language = (new Language)->createModel($this);

        $response = new LanguageResource($language);

        event(new CreateEvent($language, $this->all(), $response));

        return $response;

    }
}
