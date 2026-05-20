<?php

namespace Database\Factories;

use App\Models\Storage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Storage>
 */
class StorageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->city() . ' Warehouse',
        ];
    }
}
