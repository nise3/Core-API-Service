<?php

namespace App\Policies;

use App\Models\LocUpazila;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LocUpazilaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any locUpazilas.
     *
     * @param User $authUser
     * @return bool
     */
    public function viewAny(User $authUser): bool
    {
        return $authUser->hasPermission('view_any_upazila');

    }

    /**
     * Determine whether the user can view the locUpazila.
     *
     * @param User $authUser
     * @param LocUpazila $locUpazila
     * @return bool
     */
    public function view(User $authUser, LocUpazila $locUpazila)
    {
        return $authUser->hasPermission('view_single_upazila');
    }

    /**
     * Determine whether the user can create locUpazilas.
     *
     * @param User $authUser
     * @return bool
     */
    public function create(User $authUser): bool
    {
        return $authUser->hasPermission('create_upazila');
    }

    /**
     * Determine whether the user can update the locUpazila.
     *
     * @param User $authUser
     * @param LocUpazila $locUpazila
     * @return bool
     */
    public function update(User $authUser, LocUpazila $locUpazila): bool
    {
        return $authUser->hasPermission('update_upazila');
    }

    /**
     * Determine whether the user can delete the locUpazila.
     *
     * @param User $authUser
     * @param LocUpazila $locUpazila
     * @return bool
     */
    public function delete(User $authUser, LocUpazila $locUpazila): bool
    {
        return $authUser->hasPermission('delete_upazila');
    }
}
