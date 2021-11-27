<?php

namespace App\Http\Controllers;

use App\Enums\ProductStatus;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Resources\ProductResource;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Product::class, 'product');
    }

    public function index(): JsonResource
    {
        return ProductResource::collection(
            QueryBuilder::for(Product::class)
                ->allowedFilters([
                    AllowedFilter::exact('id'),
                    AllowedFilter::exact('name'),
                    AllowedFilter::exact('user_id'),
                ])
                ->with('tags')
                ->paginate()
        );
    }

    public function show(Product $product): JsonResource
    {
        return new ProductResource($product);
    }

    public function store(ProductRequest $request): JsonResource
    {
        $validated = $request->validated();
        $product = Product::create(array_merge($validated, [
            'status' => ProductStatus::CREATED,
            'user_id' => Auth::user()->id,
        ]));
        $product->tags()->sync($validated['tags']);

        return new ProductResource($product);
    }

    public function update(Product $product, ProductRequest $request): JsonResource
    {
        $validated = $request->validated();
        $product->update($validated);
        $product->tags()->sync($validated['tags']);

        return new ProductResource($product);
    }

    public function destroy(Product $product): JsonResponse
    {
        $product->deleteOrFail();

        return $this->respondWithSuccess();
    }
}
