<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Provider;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'        => $this->faker->words(2, true),
            'parent_id'   => null,
            'provider_id' => null,
        ];
    }

    public function root(int $providerId): static
    {
        return $this->state([
            'parent_id'   => null,
            'provider_id' => $providerId,
        ]);
    }

    public function childOf(int $parentId): static
    {
        return $this->state([
            'parent_id'   => $parentId,
            'provider_id' => null,
        ]);
    }
}
