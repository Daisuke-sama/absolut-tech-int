<?php

namespace App\Controller;

use App\Exception\IncorrectCellException;
use App\Exception\SessionAlreadyExistsException;
use App\Exception\UserServiceException;
use App\Handler\UserHandler;
use App\Utility\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationStartController extends AbstractController
{
    /**
     * @Route("/user/reg", name="registration_start", methods={"POST"})
     */
    public function index(
        Request $request,
        UserHandler $userHandler,
        LoggerInterface $logger
    ): Response {
        try {
            $userHandler->handleRegistrationStart($request->request->get('cell'));
        } catch (IncorrectCellException $e) {
            return $this->json([
                'message' => $e->getMessage(),
            ], 422);
        } catch (SessionAlreadyExistsException $e) {
            return $this->json([
                'message' => $e->getMessage() . ' You can try to drop the existing session and run this request again.',
            ], $e->getCode());
        } catch (UserServiceException $e) {
            $logger->debug('User was not created.', [$e->getMessage(), $e->getTrace()]);
            return $this->json([
                'message' => 'Something went wrong during user creation. Try again.',
            ], 500);
        } catch (\Exception $e) {
            return $this->json([
                'message' => 'We are experiencing issues with SMS request. Try again.',
            ], 503);
        }

        return $this->json([
            'message' => 'Wait for the SMS. Provide it to confirm the registration.',
        ]);
    }
}
