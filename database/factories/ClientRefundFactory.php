<?php

namespace Database\Factories;

use App\Models\ClientRefund;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ClientRefund>
 */
class ClientRefundFactory extends Factory
{
    public function definition(): array
    {
        return [
            'order_item_id' => OrderItem::factory(),
            'qty'           => $this->faker->numberBetween(1, 10),
            'refunded_at'   => now()->toDateString(),
        ];
    }
}
