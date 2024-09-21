<?php

namespace App\Http\Requests\Search;

use App\Models\Search;
use App\Http\Resources\Models\SearchResource;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShowRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        //
    }

    public function authorize()
    {

        $search = Search::findOrFail($this->search_id);

        return $this->user()->can('view', $search);

    }

    public function rules()
    {
        return [
            'load_relations' => [
                'nullable',
                'array',
                Rule::in(Search::$loadable_relations)
            ],
            'load_counts' => [
                'nullable',
                'array',
                Rule::in(Search::$loadable_counts)
            ],
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

        $search = Search::where('id', $this->search_id)
            ->with($this->load_relations ?? [])
            ->withCount($this->load_counts ?? [])
            ->firstOrFail();

        return new SearchResource($search);

    }
    
}
