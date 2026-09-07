<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\JsonApi\JsonApiResource;

class ProductCategoryResource extends JsonApiResource
{
    public const ALLOWED_FIELDS = [
        'name',
        'slug',
        'parent_id',
        'is_active',
        'created_at',
        'updated_at',
    ];

    public const ALLOWED_INCLUDES = [
        'parent',
        'children',
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
            'parent_id' => $this->parent_id,
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
            'parent' => fn() => ProductCategoryResource::make($this->parent),
            'children' => fn() => ProductCategoryResource::collection(
                $this->children->where('is_active', true),
            ),
        ];
    }
}
