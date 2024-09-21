<?php

namespace App\Http\Requests\Search;

use App\Models\Search;
use App\Http\Resources\Models\SearchResource;
use App\Http\Events\Search\Events\UpdateEvent;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {
        
        $search = Search::findOrFail($this->search_id);

        return $this->user()->can('update', $search);

    }

    public function rules()
    {
        return [
            //
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

        $search = $search->updateModel($this);

        $response = new SearchResource($search);

        event(new UpdateEvent($search, $this->all(), $response));

        return $response;

    }

}
