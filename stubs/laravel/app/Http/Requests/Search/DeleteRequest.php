<?php

namespace App\Http\Requests\Search;

use App\Models\Search;
use App\Http\Resources\Models\SearchResource;
use App\Http\Events\Search\Events\DeleteEvent;
use Illuminate\Foundation\Http\FormRequest;

class DeleteRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {
        
        $search = Search::findOrFail($this->search_id);

        return $this->user()->can('delete', $search);

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

        $search = Search::findOrFail($this->search_id);

        $search->deleteModel();

        $response = new SearchResource($search);

        event(new DeleteEvent($search, $this->all(), $response));

        return $response;

    }
    
}
