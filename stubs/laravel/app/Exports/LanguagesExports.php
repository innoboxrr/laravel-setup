<?php

namespace App\Exports;

use App\Models\Language;
use Illuminate\Contracts\View\View;
use Innoboxrr\SearchSurge\Search\Builder;
use Maatwebsite\Excel\Concerns\FromView;

class LanguagesExports implements FromView
{
    protected $data;

    public function __construct(array $data)
    {

        $this->data = $data;

    }

    public function view(): View
    {
        return view(
            config(
                'app.excel_view',
                'excel.'
            ).'language',
            [
                'languages' => $this->getQuery(),
                'exportCols' => Language::$export_cols,
            ]
        );
    }

    public function getQuery()
    {

        $builder = new Builder();

        return $builder->get(Language::class, $this->data);

    }
}
