<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Product;
use App\Http\Resources\V1\ProductResource;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\QueryBuilder\QueryBuilder;

class ProductService
{
    /**
     * List products
     * @return LengthAwarePaginator<int, Product>
     */
    public function listProducts(): LengthAwarePaginator
    {
        return $this->productQuery()
            ->paginate();
    }

    /**
     * Get product by ID
     * @param string $id
     * @throws ModelNotFoundException
     * @return Product
     */
    public function getProductById(string $id): Product
    {
        return $this->productQuery()
            ->findOrFail($id);
    }

    private function productQuery(): QueryBuilder
    {
        return QueryBuilder::for(Product::query())
            ->allowedFields(...ProductResource::ALLOWED_FIELDS)
            ->allowedIncludes(...ProductResource::ALLOWED_INCLUDES)
            ->allowedFilters(...ProductResource::ALLOWED_FILTERS);
    }
}