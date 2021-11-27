<?php

namespace App\Rules;

use App\Models\Tag;
use Illuminate\Contracts\Validation\Rule;

class TagsRule implements Rule
{
    public function passes(mixed $attribute, mixed $value): bool
    {
        $count = count($value);
        return $count === 0 || $count === Tag::whereIn('id', $value)->count();
    }

    public function message(): string
    {
        return trans('validation.tags.non_existent');
    }
}
