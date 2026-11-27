<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * La vista de la SPA es pública: el router del front decide qué pantalla toca
 * y cada llamada a la API se autoriza por su cuenta.
 */
class SpaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [];
    }

    /**
     * Una petición a la API que no existe, o una que espera JSON, sigue siendo
     * un 404 y no recibe el HTML de la SPA.
     */
    public function handle()
    {
        abort_if($this->is('api/*') || $this->expectsJson(), 404);

        return view('app');
    }
}
