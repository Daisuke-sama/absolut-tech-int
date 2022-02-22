<?php

namespace App\SmsService\Converter;

use App\Model\SmsCheckResponseModel;

interface ConverterInterface
{
    public function convert(string $data): SmsCheckResponseModel;
}
