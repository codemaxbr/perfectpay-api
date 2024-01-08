<?php

namespace App\Events;

use App\Models\Customer;

class CustomerDeleted extends Event
{
    public Customer $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }
}
