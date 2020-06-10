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
        // $this->app->bind(
        //     'App\Http\Repositories\Interfaces\UserRepositoryInterface',
        //     'App\Http\Repositories\UserRepository'
        // );
        $this->app->when('App\Http\Controllers\UserController')
          ->needs('App\Http\Repositories\Interfaces\UserRepositoryInterface')
          ->give('App\Http\Repositories\UserRepository');
        $this->app->when('App\Http\Controllers\SeekerController')
          ->needs('App\Http\Repositories\Interfaces\UserRepositoryInterface')
          ->give('App\Http\Repositories\SeekerRepository');
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
