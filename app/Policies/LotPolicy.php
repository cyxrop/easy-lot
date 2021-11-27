<?php

namespace App\Policies;

use App\Enums\Policy;
use App\Models\Lot;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LotPolicy
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

    public function update(User $user, Lot $lot)
    {
        return $user->id === $lot->user_id ||
            $user->tokenCan(Policy::MANAGE_LOTS->value);
    }

    public function delete(User $user, Lot $lot)
    {
        return $user->id === $lot->user_id ||
            $user->tokenCan(Policy::MANAGE_LOTS->value);
    }

    public function trade(User $user, Lot $lot)
    {
        return $user->id !== $lot->user_id;
    }
}
