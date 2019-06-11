<?php

/*
 * This file is part of CarePlan Manager by CircleLink Health.
 */

namespace Venturecraft\Revisionable;

use Illuminate\Support\ServiceProvider;

class RevisionableServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/revisionable.php' => config_path('revisionable.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../../migrations/' => database_path('migrations'),
        ], 'migrations');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
    }

    /**
     * Register the application services.
     */
    public function register()
    {
    }
}
