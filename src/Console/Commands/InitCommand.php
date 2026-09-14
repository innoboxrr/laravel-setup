<?php

namespace Innoboxrr\LaravelSetup\Console\Commands;

use Illuminate\Console\Command;

/**
 * `app:setup` y `app:install` de una vez, para quien no necesita revisar lo que
 * cambió antes de instalar.
 */
class InitCommand extends Command
{
    protected $signature = 'app:init
        {domain? : Dominio local que configurar en Laragon al terminar}
        {--react : Monta la interfaz en React; por omisión, Vue}
        {--force : Configura aunque la aplicación no parezca recién creada}
        {--without-build : No instala ni compila la interfaz}';

    protected $description = 'Configura e instala la aplicación base en un solo paso';

    public function handle(): int
    {
        $setup = $this->call('app:setup', array_filter([
            '--react' => $this->option('react'),
            '--force' => $this->option('force'),
        ]));

        if ($setup !== self::SUCCESS) {
            return $setup;
        }

        $install = $this->call('app:install', array_filter([
            '--without-build' => $this->option('without-build'),
        ]));

        if ($install !== self::SUCCESS) {
            return $install;
        }

        if ($domain = $this->argument('domain')) {
            return $this->call('configure:domain', ['domain' => $domain]);
        }

        return self::SUCCESS;
    }
}
