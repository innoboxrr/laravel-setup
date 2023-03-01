<?php

namespace Innoboxrr\LaravelAuth\Providers;

use Illuminate\Support\ServiceProvider;
use Innoboxrr\LaravelSetup\Console\Commands\AppSetupCommand;

class LaravelAuthServiceProvider extends ServiceProvider
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
