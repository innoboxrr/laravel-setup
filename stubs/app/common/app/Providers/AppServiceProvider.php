<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Las tablas de la SPA leen data, meta y links en la raíz de la
        // respuesta, sin el envoltorio `data` de los Resources.
        JsonResource::withoutWrapping();

        // log-viewer, sólo para quien administra.
        Gate::define('viewLogViewer', fn ($user = null): bool => $user !== null
            && method_exists($user, 'isAdmin')
            && $user->isAdmin());
    }
}
