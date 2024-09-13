<?php

namespace App\Http\Requests\Option;

use App\Http\Events\Option\Events\RestoreEvent;
use App\Http\Resources\Models\OptionResource;
use App\Models\Option;
use Illuminate\Foundation\Http\FormRequest;

class RestoreRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {

        $option = Option::withTrashed()->findOrFail($this->option_id);

        return $this->user()->can('restore', $option);

    }

    public function rules()
    {
        return [
            'option_id' => 'required|numeric',
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

        $option = Option::withTrashed()->findOrFail($this->option_id);

        $option->restoreModel();

        $response = new OptionResource($option);

        event(new RestoreEvent($option, $this->all(), $response));

        return $response;

    }
}
