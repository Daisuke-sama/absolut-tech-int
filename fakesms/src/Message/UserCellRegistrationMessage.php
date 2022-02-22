<?php

namespace App\Message;

final class UserCellRegistrationMessage
{
    private $cell;
    private $type;

    public function __construct(string $cell)
    {
        $this->cell = $cell;
        $this->type = 'sms';
    }

    public function getCell(): string
    {
        return $this->cell;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
