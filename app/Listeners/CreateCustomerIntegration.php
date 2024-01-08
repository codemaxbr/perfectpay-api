<?php

namespace App\Listeners;

use App\Events\CustomerCreated;
use App\Models\Customer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateCustomerIntegration
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\CustomerCreated  $event
     * @return void
     */
    public function handle(CustomerCreated $event)
    {
        /** @var Customer $customer */
        $customer = $event->customer;
    }
}
