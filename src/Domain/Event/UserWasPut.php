<?php


namespace App\Domain\Event;

use App\Domain\Model\User;

/**
 * Class UserWasPut
 */
class UserWasPut
{
    private $user;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}