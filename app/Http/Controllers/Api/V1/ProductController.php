<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ProductResource;
use App\Services\ProductService;
use App\Settings\StoreSettings;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    /**
     * List products
     */
    public function index(ProductService $productService): AnonymousResourceCollection
    {
        return ProductResource::collection($productService->listProducts())
            ->additional([
                'meta' => $this->getMetadata(),
            ]);
    }

    /**
     * Get product by ID
     *
     * @return ProductResource
     */
    public function show(ProductService $productService, string $id): ProductResource|JsonResponse
    {
        try {
            return ProductResource::make($productService->getProductById($id))
                ->additional([
                    'meta' => $this->getMetadata(),
                ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => __('Product not found')], 404);
        }
    }

    private function getMetadata(): array
    {
        return [
            'currency' => app(StoreSettings::class)->store_currency,
            'currency_symbol' => app(StoreSettings::class)->store_currency_symbol,
        ];
    }
}
