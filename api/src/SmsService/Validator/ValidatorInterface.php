<?php

namespace App\SmsService\Validator;

interface ValidatorInterface
{
    public static function validate(string $code): bool;
}
