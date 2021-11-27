<?php

namespace App\Rules;

use App\Enums\ProductStatus;
use App\Models\Product;
use Illuminate\Contracts\Validation\Rule;

class LotProductRule implements Rule
{
    private string $message;

    public function passes(mixed $attribute, mixed $value): bool
    {
        $product = Product::find($value);
        if (!$product) {
            $this->message = trans('validation.lots.product.not_found');
            return false;
        }

        if ($product->status !== ProductStatus::CREATED) {
            $this->message = trans('validation.lots.product.invalid_status');
            return false;
        }

        return true;
    }

    public function message(): string
    {
        return $this->message;
    }
}

