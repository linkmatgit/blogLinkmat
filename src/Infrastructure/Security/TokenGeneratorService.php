<?php

namespace App\Infrastructure\Security;

class TokenGeneratorService implements TokenGeneratorInterface
{
    /**
     * @throws \Exception
     */
    public function generate(int $length = 25): string
    {
        return substr(bin2hex(random_bytes((int) ceil($length / 2))), 0, $length);/** @phpstan-ignore-line */
    }
}
