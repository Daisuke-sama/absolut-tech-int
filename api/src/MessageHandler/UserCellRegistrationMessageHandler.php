<?php

namespace App\MessageHandler;

use App\Message\UserCellRegistrationMessage;
use Gedmo\Exception\BadMethodCallException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class UserCellRegistrationMessageHandler implements MessageHandlerInterface
{
    public function __invoke(UserCellRegistrationMessage $message)
    {
        // we are not handling messages here
        throw new BadMethodCallException('This is a fake method.');
    }
}
