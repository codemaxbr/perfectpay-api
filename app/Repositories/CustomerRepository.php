<?php

namespace App\Repositories;

use App\Services\CustomerService;
use App\Models\Customer;
use App\Models\CustomersAddress;
use Exception;
use Illuminate\Support\Facades\DB;

class CustomerRepository extends Repository implements CustomerService
{
    public function model()
    {
        return Customer::class;
    }

    public function fields()
    {
        $fields_customer = $this->model->getFillable();
        $address = new CustomersAddress();
        $fields_address = $address->getFillable();

        return array_merge($fields_customer, $fields_address);
    }

    public function create($data)
    {
        try {
            DB::beginTransaction();
            $customer = parent::create($data);

            if (isset($data['zipcode'])) {
                $customer->address()->create($data);
            }

            $customer->load('address');
            event(new \App\Events\CustomerCreated($customer));

            DB::commit();

            return $customer;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage(), 500);
        }
    }

    public function update($data, $id)
    {
        try {
            DB::beginTransaction();
            $customer = parent::update($data, $id);

            if (isset($data['zipcode'])) {
                /** @var CustomersAddress $address */
                $address = $customer->address;
                $address->fill($data);
                $address->save();
            }

            $customer->load('address');
            event(new \App\Events\CustomerUpdated($customer));

            DB::commit();
            return $customer;
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $customer = parent::delete($id);

            event(new \App\Events\CustomerDeleted($customer));
            DB::commit();

            return $customer;
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }
    }
}
