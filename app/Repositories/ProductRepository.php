<?php

namespace App\Repositories;

use App\Services\ProductService;
use App\Models\Product;

class ProductRepository extends Repository implements ProductService
{
    public function model()
    {
        return Product::class;
    }

    public function fields()
    {
        return $this->model->getFillable();
    }
}
