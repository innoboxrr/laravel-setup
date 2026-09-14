<?php

use Illuminate\Support\Facades\Route;

/*
 * La aplicación es una SPA: la misma vista atiende cualquier pantalla, y el
 * router del front decide cuál toca.
 *
 * Va como fallback y no como una ruta `{any}` a propósito. Una ruta fallback se
 * evalúa siempre la última, así que las del paquete de autenticación, las de la
 * API, log-viewer o el editor del .env ganan sin importar en qué orden se
 * registren. Una petición a la API que no existe sigue siendo un 404 en JSON.
 */

Route::get('/', fn () => view('app'))->name('app');

Route::fallback(function () {
    abort_if(request()->is('api/*') || request()->expectsJson(), 404);

    return view('app');
});
