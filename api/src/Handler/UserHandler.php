<?php

namespace App\Handler;

use App\AuthService\Utility\TokenGeneratorInterface;
use App\Entity\User;
use App\Exception\IncorrectCellException;
use App\Exception\IncorrectSmsCodeFormatException;
use App\Exception\InvalidSmsCodeException;
use App\Exception\NoCellFoundException;
use App\Exception\SessionAlreadyExistsException;
use App\Exception\UserServiceException;
use App\Message\UserCellRegistrationMessage;
use App\SmsService\Tester\SmsCodeFinder;
use App\SmsService\Validator\CodeValidator;
use App\UserService\UserFactory;
use App\UserService\Utility\CellUtility;
use App\UserService\Validator\RusCellValidator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Uid\Uuid;

class UserHandler
{
    private EntityManagerInterface $em;
    private UserFactory $userFactory;
    private MessageBusInterface $bus;
    private SmsCodeFinder $smsCodeFinder;
    private TokenGeneratorInterface $tokenGenerator;

    public function __construct(
        EntityManagerInterface $em,
        UserFactory $userFactory,
        MessageBusInterface $bus,
        SmsCodeFinder $smsCodeFinder,
        TokenGeneratorInterface $tokenGenerator
    ) {
        $this->em             = $em;
        $this->userFactory    = $userFactory;
        $this->bus            = $bus;
        $this->smsCodeFinder  = $smsCodeFinder;
        $this->tokenGenerator = $tokenGenerator;
    }

    public function handleRegistrationStart(string $cell): void
    {
        if ( ! RusCellValidator::validate($cell)) {
            throw new IncorrectCellException('Incorrect phone number format.', 422);
        }

        if ($this->em->getRepository(User::class)->getTokenByCell($cell)) {
            throw new SessionAlreadyExistsException('You have already been provided with the session.', 403);
        }

        $cell = CellUtility::flatCell($cell);
        try {
            $this->userFactory->create($cell);
        } catch (\Exception $e) {
            throw new UserServiceException($e->getMessage(), 500);
        }

        // TODO 2nd. check before dispatch the time passed from the first sms request.
        $cellMessage = new UserCellRegistrationMessage($cell);
        $this->bus->dispatch($cellMessage);
    }

    /**
     * @param  string  $code  From SMS
     *
     * @return string Token
     */
    public function handleRegistrationConfirm(string $code): string
    {
        if ( ! CodeValidator::validate($code)) {
            throw new IncorrectSmsCodeFormatException('Should contain 5 digits.', 403);
        }

        $result = $this->smsCodeFinder->find($code);
        if ( ! $result->isValid) {
            throw new InvalidSmsCodeException(
                sprintf('The code does not exist or invalid. You have %d attempts left.', $result->attemptsLeft,),
                403
            );
        }

        $user = $this->em->getRepository(User::class)->findOneBy(['cell' => $result->cell]);
        if ( ! $user) {
            throw new NoCellFoundException('No cell found corresponding to the code.', 404);
        }

        $token = $this->approveUser($user);

        return $token;
    }

    private function approveUser(User $user): ?string
    {
        $user->setIsConfirmed(true);
        $user->setUuid(Uuid::v4());
        $user->setApiToken($this->tokenGenerator->generateToken($user->getCell()));
        $user->setUpdatedAt(new \DateTime());
        $this->em->persist($user);
        $this->em->flush();

        return $user->getApiToken();
    }
}
