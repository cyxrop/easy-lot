<?php

namespace App\DTO;

use Illuminate\Contracts\Support\Arrayable;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Immutable;
use JetBrains\PhpStorm\Pure;

#[Immutable]
class LotMetaDTO implements Arrayable
{
    private const ARRAY_SHAPE = [
        'is_lot_end_notification_sent' => 'bool',
    ];

    public function __construct(
        private bool $isLotEndNotificationsSent,
    ) {
    }

    public function isLotEndNotificationsSent(): bool
    {
        return $this->isLotEndNotificationsSent;
    }

    #[Pure]
    public function withIsLotEndNotificationsSent(bool $isLotEndNotificationsSent): self
    {
        return new self($isLotEndNotificationsSent);
    }

    #[Pure]
    #[ArrayShape(self::ARRAY_SHAPE)]
    public function toArray(): array
    {
        return [
            'is_lot_end_notification_sent' => $this->isLotEndNotificationsSent,
        ];
    }

    #[Pure]
    public static function fromArray(
        #[ArrayShape(self::ARRAY_SHAPE)]
        array $data,
    ): self {
        return new self($data['is_lot_end_notification_sent']);
    }

    #[Pure]
    public static function defaults(): self
    {
        return new self(false);
    }
}
