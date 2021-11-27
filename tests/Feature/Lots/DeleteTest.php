<?php

namespace Tests\Feature\Lots;

use App\Enums\Policy;
use App\Models\Lot;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    public function test_positive(): void
    {
        $this->actingWith([Policy::MANAGE_LOTS->value]);

        $lot = Lot::factory()->create();

        $this->delete("/api/v1/lots/{$lot->id}")
            ->assertOk();

        $this->assertModelMissing($lot);
    }

    public function test_without_permissions_negative(): void
    {
        $this->actingWith([]);

        $lot = Lot::factory()->create();

        $this->delete("/api/v1/lots/{$lot->id}")
            ->assertForbidden();

        $this->assertModelExists($lot);
    }
}
