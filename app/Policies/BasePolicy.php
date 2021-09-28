<?php


namespace App\Policies;

abstract class BasePolicy
{

    public function hasPermissions($permission)
    {
        return true;
//        if ($user->row_status != User::ROW_STATUS_ACTIVE) {
//            return false;
//        }
//
//        if ($user->isSuperUser()) {
//            return true;
//        }
    }
}
