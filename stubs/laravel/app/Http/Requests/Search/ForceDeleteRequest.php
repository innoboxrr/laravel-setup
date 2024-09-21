<?php

namespace App\Http\Requests\Search;

use App\Models\Search;
use App\Http\Resources\Models\SearchResource;
use App\Http\Events\Search\Events\ForceDeleteEvent;
use Illuminate\Foundation\Http\FormRequest;

class ForceDeleteRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {

        $search = Search::withTrashed()->findOrFail($this->search_id);
        
        return $this->user()->can('forceDelete', $search);

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

        $search->forceDeleteModel();

        $response = new SearchResource($search);

        event(new ForceDeleteEvent($search, $this->all(), $response));

        return $response;

    }
    
}
