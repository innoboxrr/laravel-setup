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
        $this->runProcess(['composer', 'install'], 'Instalando dependencias de Composer...');
        $this->runProcess(['npm', 'install'], 'Instalando dependencias de NPM...');
        $this->runProcess(['php', 'artisan', 'route:json'], 'Generando JSON de rutas...');
        $this->runProcess(['npm', 'run', 'build'], 'Compilando los assets...');
        $this->runProcess(['php', 'artisan', 'migrate', '--force'], 'Migrando la base de datos...');
        $this->runProcess(['php', 'artisan', 'options:seed'], 'Sembrando opciones...');
        $this->runProcess(['php', 'artisan', 'vendor:publish', '--provider=Innoboxrr\\LaravelOptions\\Providers\\AppServiceProvider'], 'Publicando archivos del paquete laravel-options...');

        // Copiar archivo builder
        $this->runProcess(['cp', 'vendor/innoboxrr/larapack-generator/builder.example', 'builder'], 'Copiando archivo builder...');

        $this->replaceProvidersFiles();
        $this->registerServiceProvider();
        $this->registerAppConfig();

        $this->info('¡La instalación se ha completado con éxito!'); 
    }

    private function runProcess(array $command, string $message)
    {
        $this->info($message);
    
        $process = new Process($command);
    
        // Solo habilita TTY si no es Windows
        if (DIRECTORY_SEPARATOR !== '\\') {
            $process->setTty(true); // Permite mostrar la salida en tiempo real en sistemas basados en Unix
        }
    
        $process->setTimeout(null); // Sin límite de tiempo
        $process->run(function ($type, $buffer) {
            if (Process::ERR === $type) {
                $this->warn(trim($buffer)); // Muestra los errores como advertencias (menos dramático que rojo)
            } else {
                $this->line(trim($buffer)); // Muestra la salida normal
            }
        });
    
        if (!$process->isSuccessful()) {
            // Usar warn o line en lugar de error para que no se vea rojo
            $this->warn(trim($process->getErrorOutput()));
            throw new \RuntimeException($process->getErrorOutput());
        }
    }

    private function replaceProvidersFiles()
    {
        $appServiceProvider = file_get_contents(__DIR__ . '/../../../stubs/laravel/app/Providers/AppServiceProvider.php.stub');
        $authServiceProvider = file_get_contents(__DIR__ . '/../../../stubs/laravel/app/Providers/AuthServiceProvider.php.stub');
        $eventServiceProvider = file_get_contents(__DIR__ . '/../../../stubs/laravel/app/Providers/EventServiceProvider.php.stub');
        $routeServiceProvider = file_get_contents(__DIR__ . '/../../../stubs/laravel/app/Providers/RouteServiceProvider.php.stub');

        file_put_contents(base_path('app/Providers/AppServiceProvider.php'), $appServiceProvider);
        file_put_contents(base_path('app/Providers/AuthServiceProvider.php'), $authServiceProvider);
        file_put_contents(base_path('app/Providers/EventServiceProvider.php'), $eventServiceProvider);
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
