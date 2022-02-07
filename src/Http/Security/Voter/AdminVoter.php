<?php

namespace App\Http\Security\Voter;

use App\Domain\Auth\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class AdminVoter extends Voter
{
    public function __construct(private string $appEnv)
    {
    }

    protected function supports(string $attribute, $subject): bool
    {
        return  true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        if ('prod' === $this->appEnv) {
            return 'Linkmat' === $user->getUserIdentifier() && 1 === $user->getId();
        }

        return 'Linkmat' === $user->getUserIdentifier();

        return false;
    }
}
