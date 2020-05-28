<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Http\Repositories\Interfaces\JobRepositoryInterface',
            'App\Http\Repositories\JobRepository'
        );
        $this->app->bind(
            'App\Http\Repositories\Interfaces\UserRepositoryInterface',
            'App\Http\Repositories\UserRepository'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
