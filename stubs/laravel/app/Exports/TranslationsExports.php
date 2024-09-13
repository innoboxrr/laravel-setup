<?php

namespace App\Exports;

use App\Models\Translation;
use Illuminate\Contracts\View\View;
use Innoboxrr\SearchSurge\Search\Builder;
use Maatwebsite\Excel\Concerns\FromView;

class TranslationsExports implements FromView
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
            ).'translation',
            [
                'translations' => $this->getQuery(),
                'exportCols' => Translation::$export_cols,
            ]
        );
    }

    public function getQuery()
    {

        $builder = new Builder();

        return $builder->get(Translation::class, $this->data);

    }
}
