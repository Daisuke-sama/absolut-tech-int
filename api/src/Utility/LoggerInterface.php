<?php

namespace App\Utility;

interface LoggerInterface
{
    public function debug(string $message = '', array $context = []);
}
