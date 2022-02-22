<?php

namespace App\UserService\Validator;

interface ValidatorInterface
{
    public static function validate(string $data): bool;
}
