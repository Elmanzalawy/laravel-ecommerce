<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ProductResource;
use App\Services\ProductService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\JsonApi\AnonymousResourceCollection;

class ProductController extends Controller
{
    /**
     * List products
     * @param ProductService $productService
     * @return AnonymousResourceCollection
     */
    public function index(ProductService $productService): AnonymousResourceCollection
    {
        return ProductResource::collection($productService->listProducts());
    }

    /**
     * Get product by ID
     * @param ProductService $productService
     * @param string $id
     * @return ProductResource
     */
    public function show(ProductService $productService, string $id): ProductResource|JsonResponse
    {
        try {
            return ProductResource::make($productService->getProductById($id));
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => __('Product not found')], 404);
        }
    }
}
