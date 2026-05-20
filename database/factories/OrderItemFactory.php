<?php

namespace Database\Factories;

use App\Models\BatchProduct;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OrderItem>
 */
class OrderItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'order_id'         => Order::factory(),
            'batch_product_id' => BatchProduct::factory(),
            'qty'              => $this->faker->numberBetween(1, 50),
            'unit_price'       => $this->faker->randomFloat(2, 2, 60),
        ];
    }
}
