<?php

namespace App\Http\Requests\Language;

use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;

class UpdateJsonRequest extends FormRequest
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
            'language_id' => 'required|integer|exists:languages,id',
            'json' => 'required|json', // Verificar si existe un validador de JSON
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

        // Verificar si existe el archivo JSON
        if(file_exists($path)) {  
            // Guardar el nuevo JSON formateado
            $json = json_encode(json_decode($this->input('json'), true), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            file_put_contents($path, $json);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Json updated successfully',
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Language file not found'
        ]); 
    }

}
