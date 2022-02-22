<?php

namespace App\Controller;

use App\Handler\CodeListHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CodeListController extends AbstractController
{
    /**
     * @Route("/codes", name="code_list", methods={"GET"})
     */
    public function index(CodeListHandler $handler): Response
    {
        try {
            $data = $handler->getCodeList();
        } catch (\Exception $e) {

        }

        return $this->json([
            'message' => 'All codes',
            'data' => $data,
        ]);
    }
}
