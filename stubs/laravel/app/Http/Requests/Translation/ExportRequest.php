<?php

namespace App\Http\Requests\Translation;

use App\Http\Events\Translation\Events\ExportEvent;
use App\Models\Translation;
use Illuminate\Foundation\Http\FormRequest;

class ExportRequest extends FormRequest
{
    protected function prepareForValidation()
    {

        $this->merge([
            'paginate' => 0,
            'managed' => true,
            'except_view_any' => true,
        ]);

    }

    public function authorize()
    {
        return $this->user()->can('export', Translation::class);
    }

    public function rules()
    {
        return [
            //
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

        event(new ExportEvent($this->all(), $this->user()));

        return response()->json(['status' => true]);

    }
}
