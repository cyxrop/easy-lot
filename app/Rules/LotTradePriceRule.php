<?php

namespace App\Rules;

use App\Models\Lot;
use Illuminate\Contracts\Validation\Rule;

class LotTradePriceRule implements Rule
{
    private Lot $lot;

    public function __construct(Lot $lot)
    {
        $this->lot = $lot;
    }

    public function passes(mixed $attribute, mixed $value): bool
    {
        return $this->lot->price < $value;
    }

    public function message(): string
    {
        return trans('validation.lots.trade.invalid_price');
    }
}
