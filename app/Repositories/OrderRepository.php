<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Services\OrderService;
use Carbon\Carbon;
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

            $product = Product::find($data['product_id']);
            $data['amount'] = $product->price;
            $data['status'] = 'pending';
            $data['due'] = Carbon::now()->addDays(7)->format('Y-m-d');
            $payment_method = $data['payment_method'];

            $order = $this->model->create($data);

            /** @var Customer $customer */
            $customer = $order->customer;
            event(new \App\Events\OrderCreated($order, $product, $customer, $payment_method));
            DB::commit();

            return $order;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
}
