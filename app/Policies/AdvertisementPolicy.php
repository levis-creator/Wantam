<?php

namespace App\Policies;

use App\Models\Advertisement;
use App\Models\User;

class AdvertisementPolicy
{
    /**
     * Determine whether the user can view any advertisements.
     */
    public function viewAny(User $user): bool
    {
        return true; // Anyone can view advertisements
    }

    /**
     * Determine whether the user can view a specific advertisement.
     */
    public function view(User $user, Advertisement $advertisement): bool
    {
        return true; // Anyone can view individual advertisements
    }

    /**
     * Determine whether the user can create advertisements.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin(); // Only admins can create
    }

    /**
     * Determine whether the user can update the advertisement.
     */
    public function update(User $user, Advertisement $advertisement): bool
    {
        return $user->isAdmin(); // Only admins can update
    }

    /**
     * Determine whether the user can delete the advertisement.
     */
    public function delete(User $user, Advertisement $advertisement): bool
    {
        return $user->isAdmin(); // Only admins can delete
    }

    /**
     * Determine whether the user can activate/deactivate the advertisement.
     */
    public function toggleStatus(User $user, Advertisement $advertisement): bool
    {
        return $user->isAdmin(); // Only admins can change status
    }
}
