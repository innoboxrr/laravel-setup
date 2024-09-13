<?php

namespace App\Exports;

use App\Models\TrackingEvent;
use Innoboxrr\SearchSurge\Search\Builder;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TrackingEventsExports implements FromView
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
            ) . 'tracking_event', 
            [
                'tracking_events' => $this->getQuery(),
                'exportCols' => TrackingEvent::$export_cols
            ]
        );
    }

    public function getQuery()
    {   

        $builder = new Builder();

        return $builder->get(TrackingEvent::class, $this->data);

    }

}