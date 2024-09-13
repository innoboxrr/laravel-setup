<?php

namespace App\Http\Requests\Option;

use App\Http\Events\Option\Events\CreateEvent;
use App\Http\Resources\Models\OptionResource;
use App\Models\Option;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {

        return $this->user()->can('create', Option::class);

    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'key' => 'required|string|max:255|unique:options,key',
            'value' => 'required|string',
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

        $option = (new Option)->createModel($this);

        $response = new OptionResource($option);

        event(new CreateEvent($option, $this->all(), $response));

        return $response;

    }
}
