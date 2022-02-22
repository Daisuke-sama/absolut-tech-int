<?php

namespace App\MessageHandler;

use App\Handler\SmsSendHandler;
use App\Message\UserCellRegistrationMessage;
use App\Model\CodeModel;
use Gedmo\Exception\FeatureNotImplementedException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class SendCodeMessageHandler implements MessageHandlerInterface
{
    private SmsSendHandler $handler;

    public function __construct(SmsSendHandler $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke(UserCellRegistrationMessage $message)
    {
        $codeModel       = new CodeModel();
        $codeModel->code = $this->handler->generateCode();
        $codeModel->cell = $message->getCell();

        $this->handler->saveCode($codeModel);

        // TODO 3rd. Remove the try after implementation
        try {
            $sent = $this->handler->request($codeModel);
        } catch (FeatureNotImplementedException $e) {
            $sent = true;
        }

        if ( ! $sent) {
            $this->handler->removeCode($codeModel);
            // TODO 3rd. Move into the catch block above
            throw new \RuntimeException('Something went wrong during request', 500);
        }

        // TODO Implement resending by the 60 seconds.
    }
}
