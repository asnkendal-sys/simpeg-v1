<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
             \URL::forceSchema('https');
         $this->app['request']->server->set('HTTPS','on');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Repositories\IApiBknRepository',
            'App\Repositories\DataUtamaRepository'
        );
    }
}
