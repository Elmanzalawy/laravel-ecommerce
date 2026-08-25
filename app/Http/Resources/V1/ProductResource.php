<?php

namespace App\Http\Resources\V1;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\JsonApi\JsonApiResource;

class ProductResource extends JsonApiResource
{
    /**
     * The maximum relationship depth.
     */
    public static int $maxRelationshipDepth = 3;
    /**
     * Get the resource's attributes.
     *
     * @return array<string, mixed>
     */
    public function toAttributes(Request $request): array
    {
        /**
         * @var Product $this
         */
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
            'categories' => fn() => ProductCategoryResource::collection(
                $this->categories->where('is_active', true),
            ),
        ];
    }
}
