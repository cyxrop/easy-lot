<?php

namespace Tests\Feature\Lots;

use App\Models\Lot;
use Cache;
use Illuminate\Contracts\Cache\Lock;
use Mockery;
use Tests\TestCase;

class TradeTest extends TestCase
{
    public function test_positive(): void
    {
        /** @var Lot $lot */
        $lot = Lot::factory()->opened()->create();
        $price = $lot->price + 10;
        $this->post("/api/v1/lots/{$lot->id}/trade", ['price' => $price])
            ->assertOk();

        self::assertDatabaseHas('lots', [
            'id' => $lot->id,
            'price' => $price,
            'buyer_id' => $this->actingUser->id,
        ]);
    }

    public function test_lock_used_positive(): void
    {
        /** @var Lot $lot */
        $lot = Lot::factory()->opened()->create();
        $price = $lot->price + 10;

        $lock = Mockery::spy(Lock::class);
        $lock->shouldReceive('get')
            ->once()
            ->andReturn(true);
        Cache::shouldReceive('lock')
            ->once()
            ->with($lot->getLockKey('trade'))
            ->andReturn($lock);

        $this->post("/api/v1/lots/{$lot->id}/trade", ['price' => $price])
            ->assertOk();
    }

    public function test_not_opened_lot_negative(): void
    {
        $lot = Lot::factory()->create();
        $this->post("/api/v1/lots/{$lot->id}/trade", ['price' => $lot->price + 10])
            ->assertJsonPath('message', trans('validation.lots.trade.invalid_status'));
    }

    public function test_self_lot_negative(): void
    {
        $lot = Lot::factory()->forUser($this->actingUser)->create();
        $this->post("/api/v1/lots/{$lot->id}/trade", ['price' => $lot->price + 10])
            ->assertForbidden();
    }

    public function test_lower_price_negative(): void
    {
        $lot = Lot::factory()->forUser($this->actingUser)->create();
        $this->post("/api/v1/lots/{$lot->id}/trade", ['price' => $lot->price - 10])
            ->assertJsonValidationErrors([
                'price' => trans('validation.lots.trade.invalid_price'),
            ]);
    }
}
