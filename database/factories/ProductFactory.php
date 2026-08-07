<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => [
                'en' => $nameEn = fake()->unique()->word(),
                'ar' => fake()->unique()->word(),
            ],
            'description' => [
                'en' => fake()->paragraph(),
                'ar' => fake()->paragraph(),
            ],
            'slug' => str($nameEn)->slug(),
            'price' => $price = fake()->numberBetween(100, 1000),
            'compare_at_price' => fake()->boolean(50) ? fake()->numberBetween(99, $price) : null,
            'cost_per_item' => fake()->boolean(50) ? fake()->numberBetween(50, $price) : null,
            'quantity' => fake()->numberBetween(0, 100),
            'is_active' => fake()->boolean(80),
        ];
    }

    public function configure(): static
    {
        return $this->afterMaking(function (Product $product) {
            // ...
        })->afterCreating(function (Product $product) {
            $product->categories()->attach(ProductCategory::inRandomOrder()->take(rand(1, 3))->pluck('id'));
        });
    }
}
