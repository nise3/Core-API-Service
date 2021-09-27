<?php


namespace App\Facade;


use App\Helpers\Classes\AuthUserHandler;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Facade;

/**
 * Class AuthUser
 * @package App\Facade
 *
 *
 * @method static void setUser(User $user = null)
 * @method static User getUser()
 * @method static void setRole(Role $role)
 * @method static Role getRole()
 * @method static void setPermissions(array $permissions = [])
 * @method static array getPermissions()
 *
 *
 * @see \App\Helpers\Classes\AuthUserHandler
 */
class AuthUser extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'authUser';
    }

}
