<?php

namespace Innoboxrr\LaravelSetup\Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Innoboxrr\LaravelSetup\Tests\TestCase;

final class InstallCommandTest extends TestCase
{
    /**
     * `route:json` tiene que correr antes de compilar: la interfaz importa
     * routes.json, y sin las rutas de la API generada no encuentra ninguna.
     */
    public function test_instala_migra_siembra_y_compila_en_orden(): void
    {
        $this->assertSame(0, Artisan::call('app:install', ['--pretend' => true]));

        $this->assertSame([
            'Dependencias de Composer: composer update --no-interaction',
            'Tabla de tokens de Sanctum: '.PHP_BINARY.' artisan vendor:publish --tag=sanctum-migrations',
            'Tabla de notificaciones: '.PHP_BINARY.' artisan notifications:install',
            'Base de datos: '.PHP_BINARY.' artisan migrate --force',
            'Sitio de ejemplo: '.PHP_BINARY.' artisan db:seed --class=Database\\Seeders\\SiteOptionsSeeder --force',
            'Enlace público del almacenamiento: '.PHP_BINARY.' artisan storage:link',
            'Rutas para la interfaz: '.PHP_BINARY.' artisan route:json',
            'Dependencias de npm: npm install',
            'Compilación de la interfaz: npm run build',
        ], $this->lines());
    }

    public function test_sin_build_no_toca_npm(): void
    {
        Artisan::call('app:install', ['--pretend' => true, '--without-build' => true]);

        $output = implode("\n", $this->lines());

        $this->assertStringNotContainsString('npm', $output);
        $this->assertStringContainsString('route:json', $output);
    }

    public function test_usa_los_ejecutables_que_se_le_indican(): void
    {
        Artisan::call('app:install', ['--pretend' => true, '--composer' => '/opt/composer.phar', '--npm' => 'pnpm']);

        $lines = $this->lines();

        $this->assertContains('Dependencias de Composer: '.PHP_BINARY.' /opt/composer.phar update --no-interaction', $lines);
        $this->assertContains('Compilación de la interfaz: pnpm run build', $lines);
    }

    /**
     * Artisan::output() vacía el buffer al leerlo: se lee una sola vez.
     *
     * @return array<int, string>
     */
    private function lines(): array
    {
        return array_values(array_filter(array_map('trim', explode("\n", Artisan::output()))));
    }
}
