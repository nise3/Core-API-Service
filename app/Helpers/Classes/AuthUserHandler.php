<?php


namespace App\Helpers\Classes;


use App\Models\Role;
use App\Models\User;

class AuthUserHandler
{

    /**
     * @var User
     */
    private ?User $user = null;
    private ?Role $role = null;
    private array $permissions;

    /**
     * @param User|null $user
     */
    public function setUser(?User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param Role|null $role
     */
    public function setRole(?Role $role): void
    {
        $this->role = $role;
    }

    /**
     * @return Role|null
     */
    public function getRole(): ?Role
    {
        return $this->role;
    }

    /**
     * @return array|null
     */
    public function getPermissions(): array
    {
        return $this->permissions;
    }

    /**
     * @param array $permissions
     */
    public function setPermissions(array $permissions): void
    {
        $this->permissions = $permissions;
    }

}
