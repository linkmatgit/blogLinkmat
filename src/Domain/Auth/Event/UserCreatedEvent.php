<?php

namespace App\Domain\Auth\Event;

use App\Domain\Auth\Entity\User;

class UserCreatedEvent
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

    /**
     * @param User $user
     * @return UserCreatedEvent
     */
    public function setUser(User $user): UserCreatedEvent
    {
        $this->user = $user;
        return $this;
    }
}