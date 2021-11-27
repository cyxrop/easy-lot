<?php

namespace App\Casts;

use App\DTO\LotMetaDTO;
use http\Exception\InvalidArgumentException;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Contracts\Support\Arrayable;

class LotMetaCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes): LotMetaDTO
    {
        return LotMetaDTO::fromArray(json_decode($value, true));
    }

    public function set($model, string $key, $value, array $attributes): false|string
    {
        if (!$value instanceof Arrayable) {
            throw new InvalidArgumentException(sprintf(
                'The value %s must be instance of %s.',
                get_class($value),
                Arrayable::class),
            );
        }

        return json_encode($value->toArray());
    }
}
