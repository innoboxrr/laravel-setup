<?php

namespace App\Http\Requests\Option;

use App\Http\Events\Option\Events\UpdateEvent;
use App\Http\Resources\Models\OptionResource;
use App\Models\Option;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {

        $option = Option::findOrFail($this->option_id);

        return $this->user()->can('update', $option);

    }

    public function rules()
    {
        return [
            'option_id' => 'required|integer|exists:options,id',
            'name' => 'nullable|string|max:255',
            'key' => 'nullable|string|max:255|unique:options,key,'.$this->option_id,
            'value' => 'nullable|string',
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

        $option = Option::findOrFail($this->option_id);

        $option = $option->updateModel($this);

        $response = new OptionResource($option);

        event(new UpdateEvent($option, $this->all(), $response));

        return $response;

    }
}
