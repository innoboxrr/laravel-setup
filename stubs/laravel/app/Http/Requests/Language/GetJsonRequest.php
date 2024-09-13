<?php

namespace App\Http\Requests\Language;

use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;

class GetJsonRequest extends FormRequest
{

    protected $language;

    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {
        $this->language = Language::findOrFail($this->language_id);
        return $this->user()->can('update', $this->language);
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
        $path = config('locale-generator.lang_path') . '/' . $this->language->code . '.json';

        if(file_exists($path)) {
            $json = file_get_contents($path);
            $json = json_decode($json);
            return response()->json([
                'status' => 'success',
                'json' => $json
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Language file not found'
        ]);
    }
}
