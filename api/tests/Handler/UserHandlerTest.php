<?php

namespace Handler;

use App\AuthService\Utility\TokenGenerator;
use App\Exception\IncorrectSmsCodeFormatException;
use App\Exception\InvalidSmsCodeException;
use App\Exception\NoCellFoundException;
use App\Handler\UserHandler;
use App\Model\SmsCheckResponseModel;
use App\Repository\UserRepository;
use App\SmsService\Tester\SmsCodeFinder;
use App\UserService\UserFactory;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\MessageBus;

class UserHandlerTest extends TestCase
{
    public function testConfirmationThrowIncorrectSmsCodeFormatException(): void
    {
        $this->expectException(IncorrectSmsCodeFormatException::class);

        $userHandler = new UserHandler(
            $this->createMock(EntityManagerInterface::class),
            $this->createMock(UserFactory::class),
            $this->createMock(MessageBus::class),
            $this->createMock(SmsCodeFinder::class),
            $this->createMock(TokenGenerator::class)
        );

        $userHandler->handleRegistrationConfirm('asd');
    }

    public function testConfirmationThrowInvalidSmsCodeException(): void
    {
        $this->expectException(InvalidSmsCodeException::class);

        $userHandler = new UserHandler(
            $this->createMock(EntityManagerInterface::class),
            $this->createMock(UserFactory::class),
            $this->createMock(MessageBus::class),
            $this->getFinderMock(false),
            $this->createMock(TokenGenerator::class)
        );

        $userHandler->handleRegistrationConfirm('55555');
    }

    public function testConfirmationThrowNoCellFoundException(): void
    {
        $this->expectException(NoCellFoundException::class);

        
        $ur = $this->createMock(UserRepository::class);
        $ur->method('findOneBy')
            ->willReturn(null);
        $em =$this->createMock(EntityManager::class);
        $em->method('getRepository')
            ->willReturn($ur);

        $userHandler = new UserHandler(
            $em,
            $this->createMock(UserFactory::class),
            $this->createMock(MessageBus::class),
            $this->getFinderMock(true),
            $this->createMock(TokenGenerator::class)
        );

        $userHandler->handleRegistrationConfirm('55555');
    }

    private function getFinderMock(bool $isValid)
    {
        $checkResponseStub               = new SmsCheckResponseModel();
        $checkResponseStub->attemptsLeft = null;
        $checkResponseStub->cell         = '+7987675643';
        $checkResponseStub->message      = '';
        $checkResponseStub->isValid      = $isValid;

        $finderMock = $this->createMock(SmsCodeFinder::class);
        $finderMock
            ->method('find')
            ->willReturn($checkResponseStub);
        
        return $finderMock;
    }
}
