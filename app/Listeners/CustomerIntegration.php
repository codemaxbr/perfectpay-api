<?php

namespace App\Listeners;

use App\Events\CustomerCreated;
use App\Events\CustomerDeleted;
use App\Events\CustomerUpdated;
use App\Models\Customer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CustomerIntegration
{
    private $config;
    private $gateway;
    public $integration;

    public function __construct()
    {
        $this->gateway = env('GATEWAY_DEFAULT');
        $this->config = [
            'base_url' => env('GATEWAY_URL'),
            'access_token' => env('GATEWAY_KEY'),
        ];

        $integrationClass = 'App\\Integrations\\' . ucfirst($this->gateway) . 'Integration';
        $this->integration = new $integrationClass($this->config);
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle($event)
    {
        /** @var Customer $customer */
        $customer = $event->customer;

        switch (get_class($event)) {
            case CustomerCreated::class:
                $external_id = $this->integration->createCustomer($customer);
                if (!empty($external_id)) {
                    $customer->external_id = $external_id;
                    $customer->save();
                }
                break;

            case CustomerUpdated::class:
                $external_id = $this->integration->updateCustomer($customer, $customer->external_id);
                if (!empty($external_id)) {
                    $customer->external_id = $external_id;
                    $customer->save();
                }
                break;

            case CustomerDeleted::class:
                $this->integration->removeCustomer($customer->external_id);
                break;
        }
    }
}
