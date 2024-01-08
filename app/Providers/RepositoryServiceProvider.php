<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Services\UserService::class, \App\Repositories\UserRepository::class);
        $this->app->bind(\App\Services\ProductService::class, \App\Repositories\ProductRepository::class);
        $this->app->bind(\App\Services\CustomerService::class, \App\Repositories\CustomerRepository::class);
    }
}
