<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SeekerController;
use App\Http\Repositories\EmployeeRepository;
use App\Http\Controllers\Auth\RegisterController;

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

        $this->app->when(EmployeeController::class)
            ->needs('App\Http\Repositories\Interfaces\UserRepositoryInterface')
            ->give('App\Http\Repositories\EmployeeRepository');

        $this->app->when([EmployeeRepository::class, SeekerRepository::class])
            ->needs('App\Http\Repositories\Interfaces\UserRepositoryInterface')
            ->give('App\Http\Repositories\UserRepository');

        $this->app->when([UserController::class, RegisterController::class])
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
