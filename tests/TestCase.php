<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, WithFaker, LazilyRefreshDatabase;

    protected ?User $actingUser = null;
    protected $defaultHeaders = [
        'Accept' => 'application/json',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingWith(['*']);
    }

    /**
     * Acting as user with specified permissions.
     */
    protected function actingWith(array $permissions = [], ?User $user = null): void
    {
        $this->actingUser = $user ?? User::factory()->create();
        Sanctum::actingAs($this->actingUser, $permissions);
    }
}
