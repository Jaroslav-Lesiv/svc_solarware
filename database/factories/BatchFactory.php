<?php

namespace Database\Factories;

use App\Models\Batch;
use App\Models\Provider;
use App\Models\Storage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Batch>
 */
class BatchFactory extends Factory
{
    public function definition(): array
    {
        return [
            'provider_id'  => Provider::factory(),
            'storage_id'   => Storage::factory(),
            'purchased_at' => $this->faker->dateTimeBetween('-6 months', 'now')->format('Y-m-d'),
        ];
    }
}
