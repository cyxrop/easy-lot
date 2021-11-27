<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function test_login_and_logout_positive(): void
    {
        $email = $this->faker->email;
        $password = $this->faker->password;

        /** @var User $user */
        $user = User::factory()->create([
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $data = [
            'email' => $email,
            'password' => $password,
        ];

        $this->post('/api/v1/auth/login', $data)
            ->assertOk()
            ->assertJsonStructure(['token']);

        self::assertCount(1, $user->tokens);

        $this->delete('/api/v1/auth/logout')
            ->assertOk();
        $this->app->get('auth')->forgetGuards();

        $this->get('/api/v1/products')
            ->assertUnauthorized();
    }
}
