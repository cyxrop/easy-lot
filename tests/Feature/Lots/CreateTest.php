<?php

namespace Tests\Feature\Lots;

use App\Models\Product;
use DateTime;
use Tests\TestCase;

class CreateTest extends TestCase
{
    public function test_positive(): void
    {
        $product = Product::factory()->create();
        $data = [
            'name' => $this->faker->name,
            'description' => $this->faker->text($this->faker->numberBetween(5, 512)),
            'product_id' => $product->id,
            'price' => $this->faker->numberBetween(100),
            'started_at' => (new DateTime('+1 hour'))->format('Y-m-d H:i:s'),
            'finished_at' => (new DateTime('+2 hour'))->format('Y-m-d H:i:s'),
        ];

        $response = $this->post('/api/v1/lots', $data)
            ->assertCreated()
            ->decodeResponseJson();

        $this->assertDatabaseHas('lots', [
            'id' => $response['data']['id'],
            'name' => $data['name'],
            'product_id' => $product->id,
            'user_id' => $this->actingUser->id,
        ]);
    }
}
