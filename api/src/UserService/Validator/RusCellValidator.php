<?php

namespace App\UserService\Validator;

class RusCellValidator implements ValidatorInterface
{
    public static function validate(string $data): bool
    {
        return (bool)preg_match('/^(\+7|7|8)?[\s\-]?\(?[489]\d{2}\)?[\s\-]?\d{3}[\s\-]?\d{2}[\s\-]?\d{2}$/m', $data);
    }
}
