<?php

namespace Tests\Feature\Tags;

use App\Enums\Policy;
use Tests\TestCase;

class CreateTest extends TestCase
{
    public function test_positive(): void
    {
        $this->actingWith([Policy::MANAGE_TAGS->value]);

        $data = [
            'name' => $this->faker->name,
        ];

        $response = $this->post('/api/v1/tags', $data)
            ->assertCreated()
            ->decodeResponseJson();

        $this->assertDatabaseHas('tags', [
            'id' => $response['data']['id'],
            'name' => $data['name'],
        ]);
    }

    public function test_without_permissions_negative(): void
    {
        $this->actingWith([]);

        $this->post('/api/v1/tags', ['name' => $this->faker->name])
            ->assertForbidden();
    }
}
