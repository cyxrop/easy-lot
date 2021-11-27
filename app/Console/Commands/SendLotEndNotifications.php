<?php

namespace App\Console\Commands;

use App\Models\Lot;
use App\Notifications\LotWasNotSoldNotification;
use App\Notifications\LotWasSoldBuyerNotification;
use App\Notifications\LotWasSoldOwnerNotification;
use Cache;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class SendLotEndNotifications extends Command
{
    protected $signature = 'send-lot-end-notifications';
    protected $description = 'Send notifications about the end of the lots.';

    public function handle(): int
    {
        $this->collectLots()->chunkById(100, function (Collection $lots) {
            foreach ($lots as $lot) {
                $this->processLot($lot);
            }
        });

        $this->info("The command {$this->signature} completed successfully.");
        return Command::SUCCESS;
    }

    private function collectLots(): Lot|Builder
    {
        return Lot::where('started_at', '>', Carbon::now()->subHour()->toISOString())
            ->where('meta->is_lot_end_notification_sent', false)
            ->with(['user', 'buyer']);
    }

    private function processLot(Lot $lot): void
    {
        Cache::lock($lot->getLockKey($this->signature), 60)->get(function () use ($lot) {
            if (!$lot->buyer_id) {
                $lot->user->notify(new LotWasNotSoldNotification($lot));
            } else {
                $lot->user->notify(new LotWasSoldOwnerNotification($lot));
                $lot->buyer->notify(new LotWasSoldBuyerNotification($lot));
            }

            $lot->update([
                'meta' => $lot->meta->withIsLotEndNotificationsSent(true),
            ]);
        });
    }
}
