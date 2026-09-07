<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\ProductCategory;
use App\Http\Resources\V1\ProductCategoryResource;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\QueryBuilder\QueryBuilder;

class ProductCategoryService
{
    /**
     * List product categories
     * @return LengthAwarePaginator<int, ProductCategory>
     */
    public function listCategories(): LengthAwarePaginator
    {
        return $this->categoryQuery()
            ->paginate();
    }

    /**
     * Get product category by ID
     * @param string $id
     * @throws ModelNotFoundException
     * @return ProductCategory
     */
    public function getCategoryById(string $id): ProductCategory
    {
        return $this->categoryQuery()
            ->findOrFail($id);
    }

    private function categoryQuery(): QueryBuilder
    {
        return QueryBuilder::for(ProductCategory::query())
            ->allowedFields(...ProductCategoryResource::ALLOWED_FIELDS)
            ->allowedIncludes(...ProductCategoryResource::ALLOWED_INCLUDES)
            ->allowedFilters(...ProductCategoryResource::ALLOWED_FILTERS);
    }
}