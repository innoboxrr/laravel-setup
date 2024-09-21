<?php

namespace App\Http\Requests\Option;

use App\Http\Events\Option\Events\DeleteEvent;
use App\Http\Resources\Models\OptionResource;
use App\Models\Option;
use Illuminate\Foundation\Http\FormRequest;

class DeleteRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {

        $option = Option::findOrFail($this->option_id);

        return $this->user()->can('delete', $option);

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

        $option = Option::findOrFail($this->option_id);

        $option->deleteModel();

        $response = new OptionResource($option);

        event(new DeleteEvent($option, $this->all(), $response));

        return $response;

    }
}
