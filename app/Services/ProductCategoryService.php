<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Resources\V1\ProductCategoryResource;
use App\Models\ProductCategory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\QueryBuilder\QueryBuilder;

class ProductCategoryService
{
    /**
     * List product categories
     *
     * @return LengthAwarePaginator<int, Model>
     */
    public function listCategories(): LengthAwarePaginator
    {
        return $this->categoryQuery()
            ->paginate();
    }

    /**
     * Get product category by ID
     *
     * @throws ModelNotFoundException
     */
    public function getCategoryById(string $id): Model
    {
        return $this->categoryQuery()
            ->findOrFail($id);
    }

    private function categoryQuery(): QueryBuilder
    {
        return QueryBuilder::for(ProductCategory::class)
            ->allowedFields(...ProductCategoryResource::ALLOWED_FIELDS)
            ->allowedIncludes(...ProductCategoryResource::ALLOWED_INCLUDES)
            ->allowedFilters(...ProductCategoryResource::ALLOWED_FILTERS);
    }
}
