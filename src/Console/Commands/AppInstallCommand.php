<?php

namespace Innoboxrr\LaravelSetup\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class AppInstallCommand extends Command
{
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Instalar las dependencias y compilar el código en producción';

    /**
     * Execute the console command.
     */
    public function handle()
    {   
        set_time_limit(0);

        $this->info('Instalando dependencias...');

        // Eliminar lock file
        if (file_exists(base_path('composer.lock'))) {
            unlink(base_path('composer.lock'));
        }

        // Eliminar node_modules
        if (file_exists(base_path('node_modules'))) {
            $process = new Process(['rm', '-rf', 'node_modules']);
            $process->run();
            if (!$process->isSuccessful()) {
                throw new \RuntimeException($process->getErrorOutput());
            }
        }

        // Eliminar vendor
        if (file_exists(base_path('vendor'))) {
            $process = new Process(['rm', '-rf', 'vendor']);
            $process->run();
            if (!$process->isSuccessful()) {
                throw new \RuntimeException($process->getErrorOutput());
            }
        }

        // Ejecutar composer install con todas las dependencias
        $process = new Process(['composer', 'install -W']);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }

        $process = new Process(['npm', 'install']);
        $process->run();

        // Verificar si el proceso se ejecutó correctamente
        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }

        $process = new Process(['php', 'artisan', 'route:json']);
        $process->run();

        // Verificar si el proceso se ejecutó correctamente
        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }

        $process = new Process(['npm', 'run', 'build']);
        $process->run();

        // Verificar si el proceso se ejecutó correctamente
        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }

        $process = new Process(['cp', 'vendor/innoboxrr/larapack-generator/builder.example', 'builder']);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }

        $this->info('¡La instalación se ha completado con éxito!'); 

       
    }

}
