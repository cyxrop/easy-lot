<?php

namespace App\Policies;

use App\Enums\Policy;
use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    public function view(): bool
    {
        return true;
    }

    public function viewAny(): bool
    {
        return true;
    }

    public function create(): bool
    {
        return true;
    }

    public function update(User $user, Product $product)
    {
        return $user->id === $product->user_id ||
            $user->tokenCan(Policy::MANAGE_PRODUCTS->value);
    }

    public function delete(User $user, Product $product)
    {
        return $user->id === $product->user_id ||
            $user->tokenCan(Policy::MANAGE_PRODUCTS->value);
    }
}
