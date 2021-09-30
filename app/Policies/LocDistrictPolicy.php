<?php

namespace App\Policies;

use App\Models\LocDistrict;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LocDistrictPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any locDistricts.
     *
     * @param User $authUser
     * @return bool
     */
    public function viewAny(User $authUser): bool
    {
        return $authUser->hasPermission('view_any_district');
    }

    /**
     * Determine whether the user can view the locDistrict.
     *
     * @param User $authUser
     * @param LocDistrict $locDistrict
     * @return bool
     */
    public function view(User $authUser, LocDistrict $locDistrict): bool
    {
        return $authUser->hasPermission('view_single_district');
    }

    /**
     * Determine whether the user can create locDistricts.
     *
     * @param User $authUser
     * @return bool
     */
    public function create(User $authUser): bool
    {
        return $authUser->hasPermission('create_district');
    }

    /**
     * Determine whether the user can update the locDistrict.
     *
     * @param User $authUser
     * @param LocDistrict $locDistrict
     * @return bool
     */
    public function update(User $authUser, LocDistrict $locDistrict): bool
    {
        return $authUser->hasPermission('update_district');

    }

    /**
     * Determine whether the user can delete the locDistrict.
     *
     * @param User $authUser
     * @param LocDistrict $locDistrict
     * @return bool
     */
    public function delete(User $authUser, LocDistrict $locDistrict): bool
    {
        return $authUser->hasPermission('delete_district');
    }
}
