<?php

namespace App\Http\Requests;

use App\Rules\LotProductRule;
use Illuminate\Foundation\Http\FormRequest;

class LotRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|max:64',
            'description' => 'present|max:512',
            'product_id' => ['required', 'integer', new LotProductRule()],
            'price' => 'required|integer',
            'started_at' => 'required|bail|date|after:now',
            'finished_at' => 'required|date|after:started_at',
        ];
    }
}
