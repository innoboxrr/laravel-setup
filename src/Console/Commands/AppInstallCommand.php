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

        $this->replaceProvidersFiles();
        $this->registerServiceProvider();
        $this->registerAppConfig();

        $this->info('¡La instalación se ha completado con éxito!'); 

       
    }

    // PROVIDERS
    private function replaceProvidersFiles()
    {

        $appServiceProvider = file_get_contents(__DIR__ . '/../../../stubs/laravel/app/Providers/AppServiceProvider.php.stub');
        $authServiceProvider = file_get_contents(__DIR__ . '/../../../stubs/laravel/app/Providers/AuthServiceProvider.php.stub');
        $eventServiceProvider = file_get_contents(__DIR__ . '/../../../stubs/laravel/app/Providers/EventServiceProvider.php.stub');
        $broadcastServiceProvider = file_get_contents(__DIR__ . '/../../../stubs/laravel/app/Providers/BroadcastServiceProvider.php.stub');
        $routeServiceProvider = file_get_contents(__DIR__ . '/../../../stubs/laravel/app/Providers/RouteServiceProvider.php.stub');

        file_put_contents(base_path('app/Providers/AppServiceProvider.php'), $appServiceProvider);
        file_put_contents(base_path('app/Providers/AuthServiceProvider.php'), $authServiceProvider);
        file_put_contents(base_path('app/Providers/EventServiceProvider.php'), $eventServiceProvider);
        file_put_contents(base_path('app/Providers/BroadcastServiceProvider.php'), $broadcastServiceProvider);
        file_put_contents(base_path('app/Providers/RouteServiceProvider.php'), $routeServiceProvider);
    }

    private function registerAppConfig()
    {
        // Buscar el stub en  __DIR__ . '/../../../stubs/laravel/bootstrap/app.php.stub'
        $appFile = file_get_contents(__DIR__ . '/../../../stubs/laravel/bootstrap/app.php.stub');
        // Poner el contenido en el archivo bootstrap/app.php
        file_put_contents(base_path('bootstrap/app.php'), $appFile);
    }

    private function registerServiceProvider()
    {
        // Buscar el stub en  __DIR__ . '/../../../stubs/laravel/bootstrap/providers.php.stub'
        $providersFile = file_get_contents(__DIR__ . '/../../../stubs/laravel/bootstrap/providers.php.stub');
        // Poner el contenido en el archivo bootstrap/providers.php
        file_put_contents(base_path('bootstrap/providers.php'), $providersFile);
    }

}
