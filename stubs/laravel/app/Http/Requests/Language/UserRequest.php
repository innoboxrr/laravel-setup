<?php

namespace App\Http\Requests\Language;

use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {
        return true;
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
        if(auth()->check()) {
            return auth()->user()->language ?? Language::where('code', 'en')->first();
        } 
        return null;
    }
}
