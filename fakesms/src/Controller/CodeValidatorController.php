<?php

namespace App\Controller;

use App\Model\SmsCheckRequestModel;
use Gedmo\Exception\FeatureNotImplementedException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CodeValidatorController extends AbstractController
{
    /**
     * @Route("/codes/find", name="code_validator")
     */
    public function index(Request $request, SerializerInterface $serializer): Response
    {
        $checkRequest = $serializer->deserialize($request->getContent(), SmsCheckRequestModel::class, 'json');

        // TODO find in the database the code and return true.
        // TODO cover the code expiration.
        throw new FeatureNotImplementedException();
    }
}
