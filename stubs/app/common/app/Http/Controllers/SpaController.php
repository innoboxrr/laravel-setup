<?php

namespace App\Http\Controllers;

use App\Http\Requests\SpaRequest;

/**
 * Atiende cualquier pantalla de la SPA. Como todo controlador del ecosistema,
 * no lleva lógica: la decisión vive en el FormRequest.
 */
class SpaController extends Controller
{
    public function __invoke(SpaRequest $request)
    {
        return $request->handle();
    }
}
