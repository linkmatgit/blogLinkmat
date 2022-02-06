<?php

namespace App\Domain\Auth\Event;

use App\Domain\Auth\Entity\User;

class UserConfirmedEvent
{
    public function __construct(private User $user)
    {
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}
