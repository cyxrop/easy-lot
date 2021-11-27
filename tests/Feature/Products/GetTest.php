<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use Tests\TestCase;

class GetTest extends TestCase
{
    public function test_index_positive(): void
    {
        [$product] = Product::factory()->count(3)->create();

        $this->get('/api/v1/products?' . http_build_query([
                'filter' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'user_id' => $product->user_id,
                ],
            ]))
            ->assertOk()
            ->assertJsonPath('data.0.id', $product->id)
            ->assertJsonCount(1, 'data');
    }

    public function test_positive(): void
    {
        $product = Product::factory()->create();

        $this->get("/api/v1/products/{$product->id}")
            ->assertOk()
            ->assertJsonFragment([
                'data' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'status' => $product->status,
                    'user_id' => $product->user_id,
                    'tags' => [],
                    'created_at' => $product->created_at,
                    'updated_at' => $product->updated_at,
                ],
            ]);
    }
}
