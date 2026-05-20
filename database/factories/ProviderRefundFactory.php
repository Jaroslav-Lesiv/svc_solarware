<?php

namespace Database\Factories;

use App\Models\BatchProduct;
use App\Models\ProviderRefund;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProviderRefund>
 */
class ProviderRefundFactory extends Factory
{
    public function definition(): array
    {
        return [
            'batch_product_id' => BatchProduct::factory(),
            'qty'              => $this->faker->numberBetween(1, 20),
            'refunded_at'      => now()->toDateString(),
        ];
    }
}
