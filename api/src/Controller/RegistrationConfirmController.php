<?php

namespace App\Controller;

use App\Exception\IncorrectSmsCodeFormatException;
use App\Exception\InvalidSmsCodeException;
use App\Exception\NoCellFoundException;
use App\Handler\UserHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationConfirmController extends AbstractController
{
    /**
     * @Route("/user/confirm", name="registration_confirm", methods={"POST"})
     */
    public function index(Request $request, UserHandler $userHandler): Response
    {
        // TODO 2nd. Cover the token expiration
        try {
            $token = $userHandler->handleRegistrationConfirm($request->request->get('code'));
        } catch (IncorrectSmsCodeFormatException $e) {
            return $this->json([
                'message' => $e->getMessage(),
            ], 422);
        } catch (InvalidSmsCodeException | NoCellFoundException $e) {
            return $this->json([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }

        $response = new JsonResponse([
            'message' => 'Welcome to your account!',
        ], 200);
        $response->headers->setCookie(new Cookie('X-AUTH-TOKEN', $token));

        return $response;
    }
}
