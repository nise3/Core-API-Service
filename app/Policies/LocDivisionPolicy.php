<?php

namespace App\Policies;

use App\Models\LocDivision;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LocDivisionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any locDivisions.
     *
     * @param  User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the locDivision.
     *
     * @param User  $user
     * @param  LocDivision  $locDivision
     * @return mixed
     */
    public function view(User $user, LocDivision $locDivision)
    {
        return false;
    }

    /**
     * Determine whether the user can create locDivisions.
     *
     * @param User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the locDivision.
     *
     * @param  User  $user
     * @param  LocDivision  $locDivision
     * @return mixed
     */
    public function update(User $user, LocDivision $locDivision)
    {
        //
    }

    /**
     * Determine whether the user can delete the locDivision.
     *
     * @param  User  $user
     * @param  LocDivision  $locDivision
     * @return mixed
     */
    public function delete(User $user, LocDivision $locDivision)
    {
        //
    }
}
