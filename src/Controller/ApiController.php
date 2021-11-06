<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
    * @Route("/api/user", name="test-user")
    */
    public function apiUserTest()
    {
        return $this->json([
                'message' => 'this is a user route',
        ]);
    }

    /**
    * @Route("/api/admin", name="test-admin")
    */
    public function apiAdminTest()
    {
        return $this->json([
                'message' => 'this is a admin route',
        ]);
    }
}
