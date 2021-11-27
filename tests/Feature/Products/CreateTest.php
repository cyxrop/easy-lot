<?php

namespace Tests\Feature\Products;

use App\Enums\ProductStatus;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class CreateTest extends TestCase
{
    public function test_positive(): void
    {
        $data = [
            'name' => $this->faker->name,
            'description' => $this->faker->text($this->faker->numberBetween(5, 512)),
            'tags' => [],
        ];

        $response = $this->post('/api/v1/products', $data)
            ->assertCreated()
            ->decodeResponseJson();

        $this->assertDatabaseHas('products', [
            'id' => $response['data']['id'],
            'name' => $data['name'],
            'status' => ProductStatus::CREATED,
        ]);
    }

    public function test_with_tags_positive(): void
    {
        /** @var Collection $tags */
        $tags = Tag::factory()->count(2)->create();
        $data = [
            'name' => $this->faker->name,
            'description' => $this->faker->text($this->faker->numberBetween(5, 512)),
            'tags' => $tags->pluck('id'),
        ];

        $response = $this->post('/api/v1/products', $data)
            ->assertCreated()
            ->decodeResponseJson();

        self::assertCount(2, Product::find($response['data']['id'])->tags);
    }

    public function test_with_non_existent_tags_negative(): void
    {
        /** @var Collection $tags */
        $tags = Tag::factory()->count(2)->create();
        $data = [
            'name' => $this->faker->name,
            'description' => $this->faker->text($this->faker->numberBetween(5, 512)),
            'tags' => $tags->pluck('id')->merge([-1]),
        ];

        $this->post('/api/v1/products', $data)
            ->assertInvalid([
                'tags' => trans('validation.tags.non_existent'),
            ]);
    }
}
