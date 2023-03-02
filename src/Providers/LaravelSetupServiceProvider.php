<?php

namespace Innoboxrr\LaravelSetup\Providers;

use Illuminate\Support\ServiceProvider;
use Innoboxrr\LaravelSetup\Console\Commands\AppSetupCommand;

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
        ]);

    }
}
