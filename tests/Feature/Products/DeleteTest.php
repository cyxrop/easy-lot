<?php

namespace Tests\Feature\Products;

use App\Enums\Policy;
use App\Models\Product;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    public function test_positive(): void
    {
        $this->actingWith([Policy::MANAGE_PRODUCTS->value]);

        $product = Product::factory()->create();

        $this->delete("/api/v1/products/{$product->id}")
            ->assertOk();

        $this->assertModelMissing($product);
    }

    public function test_without_permissions_negative(): void
    {
        $this->actingWith([]);

        $product = Product::factory()->create();

        $this->delete("/api/v1/products/{$product->id}")
            ->assertForbidden();

        $this->assertModelExists($product);
    }
}
