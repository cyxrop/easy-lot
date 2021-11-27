<?php

namespace App\Http\Requests;

use App\Rules\LotTradePriceRule;
use Illuminate\Foundation\Http\FormRequest;

class LotTradeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'price' => ['required', 'integer', new LotTradePriceRule($this->route('lot'))],
        ];
    }
}
