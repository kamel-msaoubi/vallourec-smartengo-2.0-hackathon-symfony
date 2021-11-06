<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    #[Route('/auth', name: 'auth')]
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/AuthController.php',
        ]);
    }
    
    #[Route('/api/test', name: 'test')]
    public function test(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new authenticated controller!',
            'path' => 'src/Controller/AuthController.php',
        ]);
    }
}
