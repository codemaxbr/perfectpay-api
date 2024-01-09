<?php

namespace App\Providers;

use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \App\Events\CustomerCreated::class => [
            \App\Listeners\CustomerIntegration::class,
        ],

        \App\Events\CustomerUpdated::class => [
            \App\Listeners\CustomerIntegration::class,
        ],

        \App\Events\CustomerDeleted::class => [
            \App\Listeners\CustomerIntegration::class,
        ],

        \App\Events\OrderCreated::class => [
            \App\Listeners\OrderIntegration::class,
        ],
    ];

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
