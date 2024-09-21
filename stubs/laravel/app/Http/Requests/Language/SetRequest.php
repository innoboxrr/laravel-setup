<?php

namespace App\Http\Requests\Language;

use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;

class SetRequest extends FormRequest
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
        $language = Language::where('code', request()->code)->firstOrFail();
        if(auth()->check()) {
            if($language) {
                auth()->user()->language_id = $language->id;
                auth()->user()->save();
            }
        } 
        session(['app_locale' => $language->code]);
        return response()->json([
            'status' => 'success', 
            'message' => 'Language set successfully',
            'language' => $language
        ]);
    }
}
