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

        $process = new Process(['composer', 'update']);
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

        $this->info('¡La instalación se ha completado con éxito!'); 

       
    }

}
