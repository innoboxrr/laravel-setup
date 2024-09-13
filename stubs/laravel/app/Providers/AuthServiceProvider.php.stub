<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->policiesRegistration();
    }

    private function policiesRegistration()
    {
        $cacheKey = 'auth_policies';

        $policies = Cache::remember($cacheKey, now()->addDay(), function () {
            return $this->customDiscoverPolicies();
        });

        foreach ($policies as $model => $policy) {
            Gate::policy($model, $policy);
        }
    }

    /**
     * Descubre las políticas de los modelos.
     *
     * @return array
     */
    protected function customDiscoverPolicies()
    {
        $policies = [];
        foreach (glob(__DIR__.'/../Policies/*.php') as $file) {
            $policy = 'App\Policies\\'.substr(basename($file), 0, -4);
            $model = 'App\Models\\'.str_replace('Policy', '', $policy);

            if (class_exists($model) && class_exists($policy)) {
                $policies[$model] = $policy;
            }
        }

        return $policies;
    }
}
