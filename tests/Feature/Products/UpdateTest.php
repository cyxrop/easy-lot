<?php

namespace Tests\Feature\Products;

use App\Enums\Policy;
use App\Models\Product;
use App\Models\User;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function test_positive(): void
    {
        $this->actingWith([Policy::MANAGE_PRODUCTS->value]);

        $product = Product::factory()->create();
        $data = array_merge($product->toArray(), [
            'name' => $this->faker->name,
            'description' => $this->faker->name,
            'tags' => [],
        ]);

        $this->put("/api/v1/products/{$product->id}", $data)
            ->assertOk()
            ->assertJsonFragment(['data' => $data]);

        self::assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => $data['name'],
            'description' => $data['description'],
        ]);
    }

    public function test_by_owner_positive(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingWith([], $user);

        $product = Product::factory()->forUser($user)->create();
        $data = array_merge($product->toArray(), [
            'name' => $this->faker->name,
            'description' => $this->faker->name,
            'tags' => [],
        ]);

        $this->put("/api/v1/products/{$product->id}", $data)
            ->assertOk()
            ->assertJsonFragment(['data' => $data]);

        self::assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => $data['name'],
            'description' => $data['description'],
            'user_id' => $user->id,
        ]);
    }

    public function test_without_permissions_negative(): void
    {
        $this->actingWith([]);

        $product = Product::factory()->create();
        $data = array_merge($product->toArray(), [
            'name' => $this->faker->name,
        ]);

        $this->put("/api/v1/products/{$product->id}", $data)
            ->assertForbidden();
    }
}
