<?php

use App\Providers\AppServiceProvider;
use App\Providers\RouteServiceProvider;

return [
    AppServiceProvider::class,
    // Carga routes/api/models/*.php, las rutas que genera LaraPack.
    RouteServiceProvider::class,
];
