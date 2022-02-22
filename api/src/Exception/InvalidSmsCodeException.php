<?php

namespace App\Exception;

use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class InvalidSmsCodeException extends BadCredentialsException
{

}
