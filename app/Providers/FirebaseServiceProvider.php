<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;

class FirebaseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('firebase.auth', function ($app) {
            $factory = (new Factory)
                ->withServiceAccount(config('services.firebase.credentials'))
                ->withDatabaseUri(config('services.firebase.database_url'));

            return $factory->createAuth();
        });

        $this->app->singleton('firebase.database', function ($app) {
            $factory = (new Factory)
                ->withServiceAccount(config('services.firebase.credentials'))
                ->withDatabaseUri(config('services.firebase.database_url'));

            return $factory->createDatabase();
        });
    }

    public function boot()
    {
        //
    }
}
