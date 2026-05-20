<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'        => fake()->randomElement([
                'Earl Grey Tea', 'Green Tea Bags', 'English Breakfast',
                'Chamomile Blend', 'Peppermint Leaves', 'Darjeeling First Flush',
                'Jasmine Green Tea', 'Rooibos Blend', 'White Peony Tea', 'Oolong Supreme',
            ]) . ' ' . fake()->randomElement(['100g', '250g', '500g', '20 bags', '50 bags']),
            'category_id' => Category::factory(),
            'price'       => $this->faker->randomFloat(2, 2, 50),
        ];
    }
}
