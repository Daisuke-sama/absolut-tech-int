<?php

namespace App\Model;

class SmsCheckResponseModel
{
    public string $message;
    public bool $isValid;
    public ?int $attemptsLeft;
    public ?string $cell;
}
