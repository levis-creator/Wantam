<?php

namespace App\Policies;

use App\Models\Brand;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BrandPolicy
{
    /**
     * Determine whether the user can view any brands.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the brand.
     */
    public function view(User $user, Brand $brand): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create brands.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the brand.
     */
    public function update(User $user, Brand $brand): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the brand.
     */
    public function delete(User $user, Brand $brand): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the brand.
     */
    public function restore(User $user, Brand $brand): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the brand.
     */
    public function forceDelete(User $user, Brand $brand): bool
    {
        return $user->isAdmin();
    }
}
