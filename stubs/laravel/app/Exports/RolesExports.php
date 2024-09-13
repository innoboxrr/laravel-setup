<?php

namespace App\Exports;

use App\Models\Role;
use Illuminate\Contracts\View\View;
use Innoboxrr\SearchSurge\Search\Builder;
use Maatwebsite\Excel\Concerns\FromView;

class RolesExports implements FromView
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
            ).'role',
            [
                'roles' => $this->getQuery(),
                'exportCols' => Role::$export_cols,
            ]
        );
    }

    public function getQuery()
    {

        $builder = new Builder();

        return $builder->get(Role::class, $this->data);

    }
}
