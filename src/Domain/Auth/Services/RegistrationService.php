<?php

namespace App\Domain\Auth\Services;

use App\Domain\Auth\Entity\User;
use App\Infrastructure\Security\TokenGeneratorInterface;
use Doctrine\ORM\EntityManagerInterface;

class RegistrationService implements FormServiceInterface
{
    public function proceed(EntityManagerInterface $em, User $user, TokenGeneratorInterface $generator): void
    {

        $user->setRegisterAt(new \DateTime());
        $user->setConfirmationToken($generator->generate(60));
        $em->persist($user);
        $em->flush();
    }

    public function confirmToken(EntityManagerInterface $em, User $user): void
    {
        $user->setConfirmationToken(null);
        $em->flush();
    }
}
