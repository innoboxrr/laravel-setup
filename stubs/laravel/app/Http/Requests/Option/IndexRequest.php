<?php

namespace App\Http\Requests\Option;

use App\Http\Resources\Models\OptionResource;
use App\Models\Option;
use Illuminate\Foundation\Http\FormRequest;
use Innoboxrr\SearchSurge\Search\Builder;

class IndexRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {
        if(!auth()->check()) return true; 
        return $this->user()->can('index', Option::class);
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

        $builder = new Builder();

        $query = $builder->get(Option::class, $this->all());

        return OptionResource::collection($query);

    }
}
