<?php

namespace App\Exports;

use App\Models\Permission;
use Innoboxrr\SearchSurge\Search\Builder;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PermissionsExports implements FromView
{

    protected $data;

    public function __construct( array $data) 
    {

        $this->data = $data;

    }

    public function view(): View
    {
        return view(
            config(
                'app.excel_view', 
                'app::excel.'
            ) . 'permission', 
            [
                'permissions' => $this->getQuery(),
                'exportCols' => Permission::$export_cols
            ]
        );
    }

    public function getQuery()
    {   

        $builder = new Builder();

        return $builder->get(Permission::class, $this->data);

    }

}