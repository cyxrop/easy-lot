<?php

namespace Tests\Feature\Tags;

use App\Enums\Policy;
use App\Models\Tag;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    public function test_positive(): void
    {
        $this->actingWith([Policy::MANAGE_TAGS->value]);

        $tag = Tag::factory()->create();

        $this->delete("/api/v1/tags/{$tag->id}")
            ->assertOk();

        $this->assertModelMissing($tag);
    }

    public function test_without_permissions_negative(): void
    {
        $this->actingWith([]);

        $tag = Tag::factory()->create();

        $this->delete("/api/v1/tags/{$tag->id}")
            ->assertForbidden();

        $this->assertModelExists($tag);
    }
}
