<?php

namespace App\Http\Requests\Search;

use App\Models\Search;
use App\Http\Resources\Models\SearchResource;
use App\Http\Events\Search\Events\CreateEvent;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {

        return $this->user()->can('create', Search::class);

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

        $search = (new Search)->createModel($this);

        $response = new SearchResource($search);

        event(new CreateEvent($search, $this->all(), $response));

        return $response;

    }
    
}
