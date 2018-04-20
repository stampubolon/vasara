<?php

namespace DynEd\Vasara;

// use DynEd\Beacon\Exceptions\InvalidHandlerException;
// use DynEd\Beacon\Handler\Slack;
use Illuminate\Support\ServiceProvider;

class VasaraServiceProvider extends ServiceProvider {

    /**
     * Boot service provider.
     */
    public function boot()
    {
        // $this->app->configure('beacon');

        // $this->mergeConfigFrom(
        //     realpath(__DIR__.'/../config/beacon.php'), 'beacon'
        // );
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        // $this->app->singleton('DynEd\Beacon\Beacon', function ($app) {

        //     $handler = null;

        //     // Slack handler
        //     if($app['config']->get('beacon.defaults.handler') === 'slack') {

        //         if( ! $webhook = $app['config']->get('beacon.slack.webhook')) {
        //             throw new InvalidHandlerException('Please provide webhook URL for Beacon\'s Slack handler.');
        //         }

        //         $handler = new Slack($webhook);
        //     }

        //     // More handler coming...

        //     return new Beacon($handler);
        // });
    }
}