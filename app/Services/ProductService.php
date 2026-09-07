<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Resources\V1\ProductResource;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\QueryBuilder\QueryBuilder;

class ProductService
{
    /**
     * List products
     *
     * @return LengthAwarePaginator<int, Model>
     */
    public function listProducts(): LengthAwarePaginator
    {
        return $this->productQuery()
            ->paginate();
    }

    /**
     * Get product by ID
     *
     * @throws ModelNotFoundException
     */
    public function getProductById(string $id): Model
    {
        return $this->productQuery()
            ->findOrFail($id);
    }

    private function productQuery(): QueryBuilder
    {
        return QueryBuilder::for(Product::class)
            ->allowedFields(...ProductResource::ALLOWED_FIELDS)
            ->allowedIncludes(...ProductResource::ALLOWED_INCLUDES)
            ->allowedFilters(...ProductResource::ALLOWED_FILTERS);
    }
}
