<?php

namespace App\Controller;

use App\AuthService\Utility\TokenGeneratorInterface;
use App\Entity\User;
use App\Message\UserCellRegistrationMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\UuidV4;

class TestController extends AbstractController
{
    /**
     * @Route("/user/auth", methods={"POST"})
     */
    public function auth(Request $request, EntityManagerInterface $em, TokenGeneratorInterface $tGen)
    {
        $cell = $request->request->get('cell');

        $user = new User();
        $user->setCell($cell);
        $user->setUuid(UuidV4::v4());
        $user->setUpdatedAt(new \DateTime());
        $user->setCreatedAt(new \DateTime());
        $user->setIsConfirmed(true);
        $user->setApiToken($tGen->generateToken($user->getCell()));

        $em->persist($user);
        $em->flush();

        return $this->json($user);
    }

    /**
     * @Route("/queue/send", methods={"GET"})
     */
    public function ampq(Request $request)
    {
        $msg = new UserCellRegistrationMessage($request->get('cell'));
        $env = new Envelope($msg);
        $envRes = $this->dispatchMessage($msg);

        return $this->json($envRes->getMessage());
    }
}
