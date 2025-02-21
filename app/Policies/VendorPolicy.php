<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vendor;

class VendorPolicy
{
    public function before(User $user)
    {

        // dd($user->user_type);
        if ($user->user_type == 'superadmin') {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Vendor $vendor): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Vendor $vendor): bool
    {
        return $user->id == $vendor->owner_id && $user->user_type == 'admin';

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Vendor $vendor): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Vendor $vendor): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Vendor $vendor): bool
    {
        //
    }
}
