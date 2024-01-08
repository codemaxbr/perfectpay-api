<?php

namespace App\Repositories;

use App\Models\Order;
use App\Services\OrderService;

class OrderRepository extends Repository implements OrderService
{
    public function fields()
    {
        return $this->model->getFillable();
    }

    public function model()
    {
        return Order::class;
    }
}
