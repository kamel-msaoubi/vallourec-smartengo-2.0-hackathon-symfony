<?php

namespace App\Controller;

use App\Entity\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class TagController extends AbstractController
{
    /**
    * @Route("/api/tags/list", name="list-tag")
    */
    public function list(SerializerInterface $serializer): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        
        $tags = $this->getDoctrine()
            ->getRepository(Tag::class)
            ->findAll();

        $entityManager->flush();
        
        $json = $serializer->serialize($tags, 'json', ['groups' => ['tag'] ]);
        return new JsonResponse(['result' => 'ok', 'data' => ['tags' => json_decode($json)]]);
    }
}
