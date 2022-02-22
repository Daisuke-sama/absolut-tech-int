<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class IncorrectSmsCodeFormatException extends BadRequestException
{

}
