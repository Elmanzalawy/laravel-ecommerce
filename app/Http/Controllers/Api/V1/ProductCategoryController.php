<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ProductCategoryResource;
use App\Services\ProductCategoryService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductCategoryController extends Controller
{
    /**
     * List product categories
     */
    public function index(ProductCategoryService $productCategoryService): AnonymousResourceCollection
    {
        return ProductCategoryResource::collection($productCategoryService->listCategories());
    }

    /**
     * Get product category by ID
     *
     * @return ProductCategoryResource
     */
    public function show(ProductCategoryService $productCategoryService, string $id): ProductCategoryResource|JsonResponse
    {
        try {
            return ProductCategoryResource::make($productCategoryService->getCategoryById($id));
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => __('Product category not found')], 404);
        }
    }
}
