<?php

namespace App\Http\Resources\Models;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {

        if ($request->has('appends') && is_array($request->get('appends'))) {
            $this->resource->setAppends($request->get('appends'));
        }

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
        $actions[] = $this->assignRole();
        $actions[] = $this->assignPermission();
        $actions[] = $this->impersonate();
        $actions[] = $this->assignBenefit();
        $actions[] = $this->sendOTP();
        $actions[] = $this->sendDirectResetPasswordLink();
        if($this->email_verified_at === null){
            $actions[] = $this->verifyEmail();
        }
        $actions[] = $this->delete();
        return $actions;
    }

    private function view()
    {
        return [
            'id' => 'view',
            'name' => 'Ver',
            'callback' => 'viewUser',
            'icon' => 'fa-eye',
            'route' => true,
            'policy' => false,
            'params' => [
                'id' => $this->id,
                'to' => [
                    'name' => 'AdminShowUser',
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
            'callback' => 'editUser',
            'icon' => 'fa-edit',
            'route' => true,
            'policy' => false,
            'params' => [
                'id' => $this->id,
                'to' => [
                    'name' => 'AdminEditUser',
                    'params' => [
                        'id' => $this->id,
                    ],
                ],
            ],
        ];
    }

    private function assignRole()
    {
        return [
            'id' => 'assignRole',
            'name' => 'Asignar Rol',
            'callback' => 'assignRole',
            'icon' => 'fa-fingerprint',
            'route' => true,
            'policy' => false,
            'params' => [
                'id' => $this->id,
                'to' => [
                    'name' => 'AdminAssignRoleUser',
                    'params' => [
                        'id' => $this->id,
                    ],
                ],
            ],
        ];
    }

    private function assignPermission()
    {
        return [
            'id' => 'assignPermission',
            'name' => 'Asignar Permiso',
            'callback' => 'assignPermission',
            'icon' => 'fa-user-tag',
            'route' => true,
            'policy' => true,
            'params' => [
                'id' => $this->id,
                'to' => [
                    'name' => 'AdminAssignPermissionUser',
                    'params' => [
                        'id' => $this->id,
                    ],
                ],
            ],
        ];
    }

    private function impersonate()
    {
        return [
            'id' => 'impersonate',
            'name' => 'Impersonate',
            'callback' => 'impersonate',
            'icon' => 'fa-user-secret',
            'route' => false,
            'policy' => auth()->user()?->canImpersonate(),
            'link' => false,
            'params' => [
                'link' => route('impersonate', $this->id),
                'target' => '_self',
            ],
        ];
    }

    private function assignBenefit()
    {
        return [
            'id' => 'assignBenefit',
            'name' => 'Asignar Beneficio',
            'callback' => 'assignBenefit',
            'icon' => 'fa-gift',
            'route' => true,
            'policy' => false,
            'params' => [
                'id' => $this->id,
                'to' => [
                    'name' => 'AdminAssignBenefitUser',
                    'params' => [
                        'id' => $this->id,
                    ],
                ],
            ],
        ];
    }

    private function sendOTP()
    {
        return [
            'id' => 'sendOTP',
            'name' => 'Enviar OTP',
            'callback' => 'sendOTP',
            'icon' => 'fa-envelope',
            'route' => false,
            'policy' => false,
            'params' => [
                'id' => $this->id,
            ],
        ];
    }

    private function sendDirectResetPasswordLink()
    {
        return [
            'id' => 'sendDirectResetPasswordLink',
            'name' => 'Reset Password',
            'callback' => 'sendDirectResetPasswordLink',
            'icon' => 'fa-envelope',
            'route' => false,
            'policy' => false,
            'params' => [
                'id' => $this->id,
            ],
        ];
    }

    private function verifyEmail()
    {
        return [
            'id' => 'verifyEmail',
            'name' => 'Verificar',
            'callback' => 'verifyEmail',
            'icon' => 'fa-envelope',
            'route' => false,
            'policy' => false,
            'params' => [
                'id' => $this->id,
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
