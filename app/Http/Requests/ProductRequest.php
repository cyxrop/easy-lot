<?php

namespace App\Http\Requests;

use App\Rules\TagsRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|max:64',
            'description' => 'present|max:512',
            'tags' => ['present', new TagsRule()],
        ];
    }
}
