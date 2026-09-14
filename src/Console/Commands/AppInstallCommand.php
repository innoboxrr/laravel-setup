<?php

namespace Innoboxrr\LaravelSetup\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

/**
 * Instala lo que `app:setup` dejó escrito: dependencias, tablas, el sitio de
 * ejemplo y la interfaz compilada.
 *
 * Cada paso es un proceso aparte: después de `composer update` los proveedores
 * de los paquetes nuevos sólo existen para un artisan que arranque de nuevo.
 */
class AppInstallCommand extends Command
{
    protected $signature = 'app:install
        {--pretend : Enseña los pasos sin ejecutarlos}
        {--without-build : No instala ni compila la interfaz}
        {--composer=composer : El ejecutable de Composer}
        {--npm=npm : El ejecutable de npm}';

    protected $description = 'Instala las dependencias, migra, siembra el sitio y compila la interfaz de la aplicación base';

    public function handle(): int
    {
        $steps = $this->steps();

        if ($this->option('pretend')) {
            foreach ($steps as [$label, $command]) {
                $this->line("{$label}: ".implode(' ', $command));
            }

            return self::SUCCESS;
        }

        set_time_limit(0);

        foreach ($steps as [$label, $command]) {
            $this->components->info($label);

            $process = new Process($command, base_path(), null, null, null);

            if (DIRECTORY_SEPARATOR !== '\\' && Process::isTtySupported()) {
                $process->setTty(true);
            }

            $process->run(fn (string $type, string $buffer) => $this->output->write($buffer));

            if (! $process->isSuccessful()) {
                $this->components->error("Falló «{$label}»: ".implode(' ', $command));

                return self::FAILURE;
            }
        }

        $this->newLine();
        $this->components->info('La aplicación está lista. Regístrate con un correo de ADMIN_EMAILS para entrar al administrador.');

        return self::SUCCESS;
    }

    /**
     * @return array<int, array{0: string, 1: array<int, string>}>
     */
    private function steps(): array
    {
        $artisan = fn (string ...$arguments): array => [PHP_BINARY, 'artisan', ...$arguments];

        $steps = [
            ['Dependencias de Composer', [$this->option('composer'), 'update', '--no-interaction']],
            ['Tabla de tokens de Sanctum', $artisan('vendor:publish', '--tag=sanctum-migrations')],
            ['Tabla de notificaciones', $artisan('notifications:install')],
            ['Base de datos', $artisan('migrate', '--force')],
            ['Sitio de ejemplo', $artisan('db:seed', '--class=Database\\Seeders\\SiteOptionsSeeder', '--force')],
            ['Enlace público del almacenamiento', $artisan('storage:link')],
            ['Rutas para la interfaz', $artisan('route:json')],
        ];

        if (! $this->option('without-build')) {
            $steps[] = ['Dependencias de npm', [$this->option('npm'), 'install']];
            $steps[] = ['Compilación de la interfaz', [$this->option('npm'), 'run', 'build']];
        }

        return $steps;
    }
}
