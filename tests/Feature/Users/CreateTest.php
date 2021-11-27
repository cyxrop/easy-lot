<?php

namespace Tests\Feature\Users;

use Tests\TestCase;

class CreateTest extends TestCase
{
    public function test_positive(): void
    {
        $password = $this->faker->password;
        $data = [
            'email' => $this->faker->email,
            'name' => $this->faker->name,
            'password' => $password,
            'password_confirmation' => $password,
        ];

        $this->post('/api/v1/users', $data)
            ->assertCreated()
            ->assertJsonMissing(['password']);

        $this->assertDatabaseHas('users', ['email' => $data['email']]);
        $this->assertDatabaseMissing('users', ['password' => $password]);
    }
}
