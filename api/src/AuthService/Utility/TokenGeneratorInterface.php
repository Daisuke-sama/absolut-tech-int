<?php

namespace App\AuthService\Utility;

interface TokenGeneratorInterface
{
    public function generateToken(string $base = ''): string;
}
