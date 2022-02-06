<?php

namespace App\Infrastructure\Security;

interface TokenGeneratorInterface
{
    public function generate(int $length = 25): string;
}
