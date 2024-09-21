<?php

namespace App\Http\Requests\Search;

use App\Models\Search;
use App\Http\Resources\Models\SearchResource;
use App\Http\Events\Search\Events\RestoreEvent;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RestoreRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {
        
        $search = Search::withTrashed()->findOrFail($this->search_id);
        
        return $this->user()->can('restore', $search);

    }

    public function rules()
    {
        return [
            'search_id' => 'required|numeric'
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

        $search = Search::withTrashed()->findOrFail($this->search_id);

        $search->restoreModel();

        $response = new SearchResource($search);

        event(new RestoreEvent($search, $this->all(), $response));

        return $response;

    }
    
}
