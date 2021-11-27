<?php

namespace Database\Factories;

use App\DTO\LotMetaDTO;
use App\Models\Lot;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class LotFactory extends Factory
{
    protected $model = Lot::class;

    public function definition()
    {
        $startedAt = Carbon::now()->addDay();
        $finishedAt = clone $startedAt;
        $finishedAt->addHour();

        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text($this->faker->numberBetween(5, 512)),
            'price' => $this->faker->numberBetween(100, 100000),
            'product_id' => Product::factory()->create()->id,
            'user_id' => User::factory()->create()->id,
            'meta' => LotMetaDTO::defaults(),
            'started_at' => $startedAt->toISOString(),
            'finished_at' => $finishedAt->toISOString(),
        ];
    }

    public function forUser(User $user): LotFactory
    {
        return $this->state(function (array $attributes) use ($user) {
            return [
                'user_id' => $user->id,
            ];
        });
    }

    public function opened(): LotFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'started_at' => Carbon::now()->subHour(),
                'finished_at' => Carbon::now()->addHour(),
            ];
        });
    }

    public function bought(): LotFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'buyer_id' => User::factory()->create()->id,
                'started_at' => Carbon::now()->subMinutes(30),
                'finished_at' => Carbon::now()->subMinutes(15),
            ];
        });
    }
}
