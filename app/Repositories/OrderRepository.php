<?php

namespace App\Repositories;

use App\Models\Order;
use App\Services\OrderService;
use Exception;
use Illuminate\Support\Facades\DB;

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

    public function create($data)
    {
        try {
            DB::beginTransaction();

            $order = $this->model->create($data);

            dd($order);
            return $order;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
