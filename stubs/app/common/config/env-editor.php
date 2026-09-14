<?php

return [

    'paths' => [
        'backupDirectory' => storage_path('env-editor'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Rutas
    |--------------------------------------------------------------------------
    |
    | El administrador enlaza al editor del .env. Quien llega a estas rutas lee
    | y reescribe los secretos de la aplicación, así que sólo entra quien está
    | en ADMIN_EMAILS.
    |
    */

    'route' => [
        'enable' => env('ENV_EDITOR_ENABLED', true),
        'prefix' => 'env-editor',
        'name' => 'env-editor',
        'middleware' => ['web', 'auth', 'admin'],
        'gate' => null,
    ],

    'timeFormat' => 'd/m/Y H:i:s',

    'layout' => 'env-editor::layout',

];
