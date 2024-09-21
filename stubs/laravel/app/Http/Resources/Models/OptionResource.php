<?php

namespace App\Http\Resources\Models;

use Illuminate\Http\Resources\Json\JsonResource;

class OptionResource extends JsonResource
{
    public function toArray($request)
    {

        return parent::toArray($request) + [
            'actions' => $this->actions($request),
        ];

    }

    private function actions($request)
    {

        $actions = [];

        // Validaciones individuales por operación

        $actions[] = $this->view();

        $actions[] = $this->edit();

        $actions[] = $this->delete();

        return $actions;

    }

    private function view()
    {
        return [
            'id' => 'view',
            'name' => 'Ver',
            'callback' => 'viewOption',
            'icon' => 'fa-eye',
            'route' => true,
            'policy' => false,
            'params' => [
                'id' => $this->id,
                'to' => [
                    'name' => 'AdminShowOption',
                    'params' => [
                        'id' => $this->id,
                    ],
                ],
            ],
        ];
    }

    private function edit()
    {
        return [
            'id' => 'update',
            'name' => 'Editar',
            'callback' => 'editOption',
            'icon' => 'fa-edit',
            'route' => true,
            'policy' => false,
            'params' => [
                'id' => $this->id,
                'to' => [
                    'name' => 'AdminEditOption',
                    'params' => [
                        'id' => $this->id,
                    ],
                ],
            ],
        ];
    }

    private function delete()
    {
        return [
            'id' => 'delete',
            'name' => 'Eliminar',
            'callback' => 'deleteModel',
            'icon' => 'fa-trash-alt',
            'route' => false,
            'policy' => false,
            'params' => [
                'id' => $this->id,
            ],
        ];
    }
}
