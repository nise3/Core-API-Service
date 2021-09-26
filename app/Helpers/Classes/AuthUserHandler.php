<?php


namespace App\Helpers\Classes;


use App\Models\User;

class AuthUserHandler
{

    /**
     * @var null
     */
    private $user = null;


    /**
     * @param User|null $user
     */
    public function setUser(User $user = null): void
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

}
