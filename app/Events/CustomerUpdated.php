<?php

namespace App\Events;

use App\Models\Customer;

class CustomerUpdated extends Event
{
    public Customer $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }
}
