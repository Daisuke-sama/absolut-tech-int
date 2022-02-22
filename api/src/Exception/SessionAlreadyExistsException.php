<?php

namespace App\Exception;

use Symfony\Component\Security\Core\Exception\AuthenticationServiceException;

class SessionAlreadyExistsException extends AuthenticationServiceException
{

}
