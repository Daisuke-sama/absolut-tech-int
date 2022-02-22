<?php

namespace App\AuthService\Utility;


use Symfony\Component\Uid\Uuid;

class TokenGenerator implements TokenGeneratorInterface
{
    public function generateToken(string $base = ''): string
    {
        return base64_encode(Uuid::v4().$base);
    }
}
