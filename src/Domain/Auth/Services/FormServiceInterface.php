<?php

namespace App\Domain\Auth\Services;

use App\Domain\Auth\Entity\User;
use App\Infrastructure\Security\TokenGeneratorInterface;
use Doctrine\ORM\EntityManagerInterface;

interface FormServiceInterface
{
    public function proceed(EntityManagerInterface $em, User $user, TokenGeneratorInterface $generator): void;

    public function confirmToken(EntityManagerInterface $em, User $user): void;
}
