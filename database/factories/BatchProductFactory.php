<?php

namespace Database\Factories;

use App\Models\Batch;
use App\Models\BatchProduct;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BatchProduct>
 */
class BatchProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'batch_id'   => Batch::factory(),
            'product_id' => Product::factory(),
            'qty'        => $this->faker->numberBetween(50, 500),
            'unit_cost'  => $this->faker->randomFloat(2, 1, 20),
        ];
    }
}
