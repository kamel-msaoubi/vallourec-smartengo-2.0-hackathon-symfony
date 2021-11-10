<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Reaction;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ReactionController extends AbstractController
{

    /**
    * @Route("/api/reaction/create", name="create-reaction")
    * @param Request $request
    */
    public function create(Request $request, SerializerInterface $serializer): JsonResponse
    {
        $post_data = json_decode($request->getContent(), true);
        $entityManager = $this->getDoctrine()->getManager();

        $reaction = new Reaction();
        $article = new Article();
        
        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->find($post_data['article']["id"]);
        $reaction->setType($post_data['type']);
        $reaction->setArticles($article);
        $reaction->setUsers($request->attributes->get('user'));
        $reaction->setCreatedAt(new \DateTimeImmutable());
        $entityManager->persist($reaction);

        $entityManager->flush();
        
        $json = $serializer->serialize($reaction, 'json', ['groups' => ['reaction', 'article', 'user'] ]);
        return new JsonResponse(['result' => 'ok', 'data' => ['message' => 'Saved new reaction with id '.$reaction->getId(), 'reaction' => json_decode($json)]]);
    }
}