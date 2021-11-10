<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CommentController extends AbstractController
{

    /**
    * @Route("/api/comment/create", name="create-comment")
    * @param Request $request
    */
    public function create(Request $request, SerializerInterface $serializer): JsonResponse
    {
        $post_data = json_decode($request->getContent(), true);
        $entityManager = $this->getDoctrine()->getManager();

        $comment = new Comment();
        $article = new Article();
        
        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->find($post_data['article']["id"]);
        $comment->setContent($post_data['content']);
        $comment->setArticles($article);
        $comment->setUsers($request->attributes->get('user'));
        $comment->setCreatedAt(new \DateTimeImmutable());
        $entityManager->persist($comment);

        $entityManager->flush();
        
        $json = $serializer->serialize($comment, 'json', ['groups' => ['comment', 'user'] ]);
        return new JsonResponse(['result' => 'ok', 'data' => ['message' => 'Saved new comment with id '.$comment->getId(), 'comment' => json_decode($json)]]);
    }
}
