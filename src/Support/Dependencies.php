<?php

namespace Innoboxrr\LaravelSetup\Support;

/**
 * Lo que instala la aplicación base, en las versiones que funcionan en Laravel
 * 13.
 *
 * Vive en un solo sitio: antes las versiones estaban escritas a mano dentro del
 * comando, y pedían `^1.0` de paquetes que ya iban por la 2, `dev-master` y
 * `^0.0`, así que una aplicación nueva instalaba versiones que no arrancaban.
 */
final class Dependencies
{
    /**
     * @return array<string, string>
     */
    public static function composer(): array
    {
        return [
            'algolia/scout-extended' => '^5.0',
            'google/recaptcha' => '^1.3',
            'innoboxrr/aws-file-manager' => '^2.0',
            'innoboxrr/laravel-audit' => '^2.1',
            'innoboxrr/laravel-auth' => '^6.0.3',
            'innoboxrr/laravel-env-editor' => '^2.1',
            'innoboxrr/laravel-notifications' => '^2.1',
            'innoboxrr/laravel-options' => '^2.1',
            'innoboxrr/laravel-uploads' => '^2.1',
            'innoboxrr/locale-generator' => '^2.1',
            'innoboxrr/routes-to-json' => '^2.1',
            'innoboxrr/search-surge' => '^3.0',
            'innoboxrr/support' => '^2.1',
            'innoboxrr/traits' => '^2.1',
            'laravel/sanctum' => '^4.3',
            'league/flysystem-aws-s3-v3' => '^3.0',
            'maatwebsite/excel' => '^4.0',
            'opcodesio/log-viewer' => '^3.24',
            'staudenmeir/belongs-to-through' => '^2.18',
            'staudenmeir/eloquent-has-many-deep' => '^1.22',
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function composerDev(): array
    {
        return [
            'innoboxrr/larapack-generator' => '^7.10.2',
        ];
    }

    /**
     * Lo que ya no se instala: `lab404/laravel-impersonate` lo sustituye
     * laravel-auth, y nada de la aplicación lo usaba.
     *
     * @return array<int, string>
     */
    public static function composerRemoved(): array
    {
        return [
            'lab404/laravel-impersonate',
        ];
    }
}
