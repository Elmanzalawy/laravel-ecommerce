<?php

namespace App\Http\Resources\V1;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\JsonApi\JsonApiResource;

/**
 * @mixin Product
 */
class ProductResource extends JsonApiResource
{
    public const ALLOWED_FIELDS = [
        'name',
        'slug',
        'description',
        'price',
        'compare_at_price',
        'cost_per_item',
        'quantity',
        'is_active',
        'created_at',
        'updated_at',
    ];

    public const ALLOWED_INCLUDES = [
        'categories',
    ];

    public const ALLOWED_FILTERS = [
        'price',
        'compare_at_price',
        'cost_per_item',
        'quantity',
        'is_active',
        'created_at',
    ];

    /**
     * Get the resource's attributes.
     *
     * @return array<string, mixed>
     */
    public function toAttributes(Request $request): array
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'price' => $this->price,
            'compare_at_price' => $this->compare_at_price,
            'cost_per_item' => $this->cost_per_item,
            'quantity' => $this->quantity,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at->format('Y-m-d H:i'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i'),
        ];
    }

    /**
     * Get the resource's relationships.
     */
    public function toRelationships(Request $request): array
    {
        return [
            'categories' => fn () => ProductCategoryResource::collection(
                $this->categories()->where('is_active', true)->get(),
            ),
        ];
    }
}
