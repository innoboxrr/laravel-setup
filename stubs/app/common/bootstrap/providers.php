<?php

use App\Providers\AppServiceProvider;
use App\Providers\EventServiceProvider;
use App\Providers\RouteServiceProvider;

return [
    AppServiceProvider::class,
    // Enlaza los eventos y listeners de app/Http/Events que genera LaraPack:
    // sin él, una exportación no avisa a quien la pidió.
    EventServiceProvider::class,
    // Carga routes/api/models/*.php, las rutas que genera LaraPack.
    RouteServiceProvider::class,
];
