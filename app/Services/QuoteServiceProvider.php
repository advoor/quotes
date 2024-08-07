<?php

namespace App\Services;


use Illuminate\Support\ServiceProvider;

class QuoteServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('quote', function ($app) {
            return new QuoteManager($app);
        });
    }
}
