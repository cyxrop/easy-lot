<?php

namespace Tests\Feature\Lots;

use App\Models\Lot;
use Tests\TestCase;

class GetTest extends TestCase
{
    public function test_index_positive(): void
    {
        /** @var Lot $lot */
        [$lot] = Lot::factory()->count(3)->create();

        $this->get('/api/v1/lots?' . http_build_query([
                'filter' => [
                    'id' => $lot->id,
                    'name' => $lot->name,
                    'user_id' => $lot->user_id,
                ],
            ]))
            ->assertOk()
            ->assertJsonPath('data.0.id', $lot->id)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.user.id', $lot->user->id)
            ->assertJsonPath('data.0.product.id', $lot->product->id);
    }

    public function test_positive(): void
    {
        $lot = Lot::factory()->create();

        $this->get("/api/v1/lots/{$lot->id}")
            ->assertOk()
            ->assertJsonFragment([
                'data' => [
                    'id' => $lot->id,
                    'name' => $lot->name,
                    'description' => $lot->description,
                    'user_id' => $lot->user_id,
                    'product_id' => $lot->product_id,
                    'price' => $lot->price,
                    'meta' => $lot->meta->toArray(),
                    'started_at' => $lot->started_at,
                    'finished_at' => $lot->finished_at,
                    'created_at' => $lot->created_at,
                    'updated_at' => $lot->updated_at,
                ],
            ]);
    }
}
