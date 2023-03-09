<?php

namespace Innoboxrr\LaravelSetup\Providers;

use Illuminate\Support\ServiceProvider;
use Innoboxrr\LaravelSetup\Console\Commands\AppSetupCommand;
use Innoboxrr\LaravelSetup\Console\Commands\AppInstallCommand;

class LaravelSetupServiceProvider extends ServiceProvider
{
    
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
        //

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        $this->commands([
            AppSetupCommand::class,
            AppInstallCommand::class
        ]);

    }
}
