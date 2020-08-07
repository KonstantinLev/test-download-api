<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/", name="api")
 * Class HomeController
 * @package App\Controller\Api
 */
class HomeController extends AbstractController
{
    /**
     * @Route("", name=".home", methods={"GET"})
     * @return Response
     */
    public function home(): Response
    {
        return $this->json([
            'name' => 'JSON API',
        ]);
    }
}