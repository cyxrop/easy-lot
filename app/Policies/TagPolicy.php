<?php

namespace App\Policies;

use App\Enums\Policy;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy
{
    use HandlesAuthorization;

    public function viewAny(): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->tokenCan(Policy::MANAGE_TAGS->value);
    }

    public function delete(User $user)
    {
        return $user->tokenCan(Policy::MANAGE_TAGS->value);
    }
}
