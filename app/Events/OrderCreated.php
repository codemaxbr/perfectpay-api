<?php

namespace App\Events;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;

class OrderCreated extends Event
{
    public $order;
    public $product;
    public $customer;
    public string $payment_method;

    public function __construct(Order $order, Product $product, Customer $customer, $payment_method = 'BOLETO')
    {
        $this->order = $order;
        $this->product = $product;
        $this->payment_method = $payment_method;
        $this->customer = $customer;
    }
}
