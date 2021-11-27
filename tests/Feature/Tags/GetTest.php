<?php

namespace Tests\Feature\Tags;

use App\Models\Tag;
use Tests\TestCase;

class GetTest extends TestCase
{
    public function test_index_positive(): void
    {
        [$tag] = Tag::factory()->count(3)->create();

        $this->get('/api/v1/tags?' . http_build_query([
                'filter' => [
                    'id' => $tag->id,
                    'name' => $tag->name,
                ],
            ]))
            ->assertOk()
            ->assertJsonPath('data.0.id', $tag->id)
            ->assertJsonCount(1, 'data');
    }
}
