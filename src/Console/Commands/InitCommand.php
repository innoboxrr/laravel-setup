<?php

namespace Innoboxrr\LaravelSetup\Console\Commands;

use Illuminate\Console\Command;

class InitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init {domain}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Configura la aplicación completa, instala dependencias y configura el dominio';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $domain = $this->argument('domain');
        
        $this->info('Iniciando la configuración completa de la aplicación...');

        // Llamar al comando app:setup
        $this->call('app:setup');
        
        // Llamar al comando app:install
        $this->call('app:install');
        
        // Llamar al comando configure:domain con el dominio proporcionado
        $this->call('configure:domain', ['domain' => $domain]);

        $this->info('¡La configuración completa ha sido exitosa!');
    }
}
