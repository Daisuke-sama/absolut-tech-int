<?php

namespace App\SmsService\Validator;

class CodeValidator implements ValidatorInterface
{
    public static function validate(string $code): bool
    {
        return (bool)preg_match('/^\d{5}$/', $code);
    }
}
