<?php

namespace Tests\Feature\Api\V1;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductEndpointsTest extends TestCase
{
    use RefreshDatabase;

    public function test_products_index_returns_a_json_api_collection(): void
    {
        $products = Product::factory()->count(2)->create();

        $response = $this->getJson('/api/v1/products');

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'type',
                        'id',
                        'attributes' => [
                            'name',
                            'slug',
                            'description',
                            'price',
                            'quantity',
                            'is_active',
                        ],
                    ],
                ],
                'links',
                'meta',
            ])
            ->assertJsonCount($products->count(), 'data')
            ->assertJsonPath('data.0.type', 'products');
    }

    public function test_product_show_returns_the_requested_product(): void
    {
        $product = Product::factory()->create();

        $response = $this->getJson("/api/v1/products/{$product->id}");

        $response->assertOk()
            ->assertJsonPath('data.type', 'products')
            ->assertJsonPath('data.id', (string) $product->id)
            ->assertJsonPath('data.attributes.slug', (string) $product->slug);
    }

    public function test_product_show_returns_not_found_for_an_unknown_product(): void
    {
        $response = $this->getJson('/api/v1/products/999999');

        $response->assertNotFound()
            ->assertJson(['error' => 'Product not found']);
    }

    public function test_product_categories_index_returns_a_json_api_collection(): void
    {
        $categories = ProductCategory::factory()
            ->count(2)
            ->state(['parent_id' => null])
            ->create();

        $response = $this->getJson('/api/v1/product-categories');

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'type',
                        'id',
                        'attributes' => [
                            'name',
                            'slug',
                            'parent_id',
                            'is_active',
                        ],
                    ],
                ],
                'links',
                'meta',
            ])
            ->assertJsonPath('data.0.type', 'product_categories');

        foreach ($categories as $category) {
            $response->assertJsonFragment([
                'type' => 'product_categories',
                'id' => (string) $category->id,
            ]);
        }
    }

    public function test_product_category_show_returns_the_requested_category(): void
    {
        $category = ProductCategory::factory()->create();

        $response = $this->getJson("/api/v1/product-categories/{$category->id}");

        $response->assertOk()
            ->assertJsonPath('data.type', 'product_categories')
            ->assertJsonPath('data.id', (string) $category->id)
            ->assertJsonPath('data.attributes.slug', (string) $category->slug);
    }

    public function test_product_category_show_returns_not_found_for_an_unknown_category(): void
    {
        $response = $this->getJson('/api/v1/product-categories/999999');

        $response->assertNotFound()
            ->assertJson(['error' => 'Product category not found']);
    }
}
