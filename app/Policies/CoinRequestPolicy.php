<?php

namespace App\Policies;

use App\Models\CoinRequest;
use App\Models\User;

class CoinRequestPolicy
{
    /**
     * Determine whether the user can view any models (Admin only).
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('viewAnyCoinRequest');
    }

    /**
     * Determine whether the user can view a specific model.
     */
    public function view(User $user, CoinRequest $coinRequest): bool
    {
        return $user->id === $coinRequest->user_id || $user->id === $coinRequest->requested_from;
    }


    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('createCoinRequest');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CoinRequest $coinRequest): bool
    {
        return $coinRequest->requested_from === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CoinRequest $coinRequest): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CoinRequest $coinRequest): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CoinRequest $coinRequest): bool
    {
        return false;
    }
}
