<?php

namespace App\Exports;

use App\Models\Option;
use Illuminate\Contracts\View\View;
use Innoboxrr\SearchSurge\Search\Builder;
use Maatwebsite\Excel\Concerns\FromView;

class OptionsExports implements FromView
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
            ).'option',
            [
                'options' => $this->getQuery(),
                'exportCols' => Option::$export_cols,
            ]
        );
    }

    public function getQuery()
    {

        $builder = new Builder();

        return $builder->get(Option::class, $this->data);

    }
}
