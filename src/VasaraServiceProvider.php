<?php

namespace DynEd\Vasara;

use Illuminate\Support\ServiceProvider;

class VasaraServiceProvider extends ServiceProvider
{
    /**
     * Boot service provider.
     */
    public function boot()
    {
        $this->publishes([
            realpath(__DIR__ . '/../config/vasara.php') => config_path('vasara.php'),
        ], 'config');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        //
    }
}