<?php

namespace App\Controller;

use App\Entity\User;
use App\UserService\Transformation\ProfileViewCreator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\SerializerInterface;

class UserProfileController extends AbstractController
{
    /**
     * @Route("/user/profile", name="user_profile", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(TokenStorageInterface $tokenStorage, ProfileViewCreator $userProfileCreator, SerializerInterface $serializer): Response
    {
        /** @var User $user */
        $user = $tokenStorage->getToken()->getUser();

        $model = $userProfileCreator->transform($user);

        return $this->json([
            'message' => $serializer->serialize($model, 'json'),
        ]);
    }
}
