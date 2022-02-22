<?php

namespace App\UserService;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserFactory implements UserFactoryInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create(string $cell): User
    {
        $user = new User();
        $user->setIsConfirmed(false);
        $user->setCell($cell);
        $user->setCreatedAt(new \DateTime());
        $user->setUpdatedAt(new \DateTime());

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
