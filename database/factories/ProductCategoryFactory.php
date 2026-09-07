<?php

namespace Database\Factories;

use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductCategory>
 */
class ProductCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nameEn = fake()->word().fake()->word().rand(1, 1000);

        return [
            'name' => [
                'en' => $nameEn,
                'ar' => fake()->word(),
            ],
            'parent_id' => fake()->boolean(10) ? null : ProductCategory::factory(),
            'is_active' => fake()->boolean(80),
            'slug' => str($nameEn)->slug(),
        ];
    }
}
