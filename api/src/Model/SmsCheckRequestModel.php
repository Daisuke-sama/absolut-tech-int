<?php

namespace App\Model;


class SmsCheckRequestModel implements \JsonSerializable
{
    public string $code;
    public \DateTime $checkingDatetime;

    public function jsonSerialize()
    {
        return [
            'code' => $this->code,
            'checkingDatetime' => $this->checkingDatetime,
        ];
    }
}
