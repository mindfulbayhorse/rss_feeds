<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Suite\Jwplayer;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
        $this->app->singleton('jwplayer', function ($app) {
                $jwplayerConfig = config('services.jwplayer');
                return new Jwplayer($jwplayerConfig['key'], $jwplayerConfig['secret']);
            });

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
