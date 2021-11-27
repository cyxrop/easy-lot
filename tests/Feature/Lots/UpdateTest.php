<?php

namespace Tests\Feature\Lots;

use App\Enums\Policy;
use App\Models\Lot;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function test_positive(): void
    {
        $this->actingWith([Policy::MANAGE_LOTS->value]);

        $lot = Lot::factory()->create();
        $data = array_merge($lot->toArray(), [
            'name' => $this->faker->name,
            'description' => $this->faker->name,
        ]);

        $this->put("/api/v1/lots/{$lot->id}", $data)
            ->assertOk()
            ->assertJsonFragment(['data' => $data]);

        self::assertDatabaseHas('lots', [
            'id' => $lot->id,
            'name' => $data['name'],
            'description' => $data['description'],
        ]);
    }

    public function test_negative(): void
    {
        $lot = Lot::factory()->opened()->create();
        $data = array_merge($lot->toArray(), [
            'name' => $this->faker->name,
            'description' => $this->faker->name,
        ]);

        $this->put("/api/v1/lots/{$lot->id}", $data)
            ->assertUnprocessable();
    }
}
