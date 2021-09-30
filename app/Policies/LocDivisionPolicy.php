<?php

namespace App\Policies;

use App\Models\LocDivision;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LocDivisionPolicy extends BasePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any locDivisions.
     *
     * @param  User $authUser
     * @return bool
     */
    public function viewAny(User $authUser): bool
    {
        return $authUser->hasPermission('view_any_division');
    }

    /**
     * Determine whether the user can view the locDivision.
     *
     * @param User $authUser
     * @param  LocDivision  $locDivision
     * @return bool
     */
    public function view(User $authUser, LocDivision $locDivision): bool
    {
        return $authUser->hasPermission('view_single_division');
    }

    /**
     * Determine whether the user can create locDivisions.
     *
     * @param User $authUser
     * @return bool
     */
    public function create(User $authUser): bool
    {
        return $authUser->hasPermission('create_division');
    }

    /**
     * Determine whether the user can update the locDivision.
     *
     * @param  User $authUser
     * @param  LocDivision  $locDivision
     * @return bool
     */
    public function update(User $authUser, LocDivision $locDivision): bool
    {
        return $authUser->hasPermission('update_division');
    }

    /**
     * Determine whether the user can delete the locDivision.
     *
     * @param  User  $authUser
     * @param  LocDivision  $locDivision
     * @return bool
     */
    public function delete(User $authUser, LocDivision $locDivision): bool
    {
        return $authUser->hasPermission('delete_division');
    }
}
