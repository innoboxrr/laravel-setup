<?php

namespace App\Http\Requests\Translation;

use App\Http\Resources\Models\TranslationResource;
use App\Models\Translation;
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
        return $this->user()->can('index', Translation::class);
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

        $query = $builder->get(Translation::class, $this->all());

        return TranslationResource::collection($query);

    }
}
