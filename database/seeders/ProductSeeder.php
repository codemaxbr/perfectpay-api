<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'name' => 'Produto recorrente',
            'description' => 'Produto com recorrência - Mensal',
            'price' => 100,
            'visible' => true,
            'is_recurrence' => true,
            'payment_cycle' => 'monthly',
        ]);

        Product::create([
            'name' => 'Produto avulso',
            'description' => 'Produto avulso de pagamento único',
            'price' => 199.9,
            'visible' => true,
            'is_recurrence' => false,
        ]);
    }
}
