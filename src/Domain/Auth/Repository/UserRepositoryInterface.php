<?php

namespace App\Domain\Auth\Repository;

use App\Domain\Auth\Entity\User;

interface UserRepositoryInterface
{
    public function findForAutoComplete(string $q): User;
}
