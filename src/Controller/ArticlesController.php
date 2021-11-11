<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ArticlesController extends AbstractController
{

    /**
    * @Route("/api/article/create", name="create-article")
    * @param Request $request
    */
    public function create(Request $request, SerializerInterface $serializer): JsonResponse
    {
        $post_data = json_decode($request->getContent(), true);
        $entityManager = $this->getDoctrine()->getManager();

        $article = new Article();
        $article->setName($post_data['name']);
        $article->setContent($post_data['content']);
        $article->setUsers($request->attributes->get('user'));
        $article->setCreatedAt(new \DateTimeImmutable());
        $entityManager->persist($article);

        $entityManager->flush();
        
        $json = $serializer->serialize($article, 'json', ['groups' => ['user','article','reaction','tag'] ]);
        return new JsonResponse(['result' => 'ok', 'data' => ['message' => 'Saved new article with id '.$article->getId(), 'article' => json_decode($json)]]);
    }
    
    /**
    * @Route("/api/article/update", name="update-article")
    * @param Request $request
    */
    public function update(Request $request): JsonResponse
    {
        $post_data = json_decode($request->getContent(), true);
        $entityManager = $this->getDoctrine()->getManager();
        $user = $request->attributes->get('user');
        $isAdmin = $request->attributes->get('idAdmin');

        
        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->find($post_data['id']);

        if ($isAdmin === true ||
            $article->getUsers()->getId() === $user->getId()) {
            $article->setName($post_data['name']);
            $article->setContent($post_data['content']);
            $article->setUpdatedAt(new \DateTimeImmutable());
            $entityManager->persist($article);
    
            $entityManager->flush();
        } else {
            throw $this->createNotFoundException(
                'No article found for id '.$post_data['id']
            );
        }

        return new JsonResponse(['result' => 'ok', 'data' => ['message' => 'Updated new article with id '.$article->getId()]]);
    }
    
    /**
    * @Route("/api/article/delete", name="delete-article")
    * @param Request $request
    */
    public function delete(Request $request): JsonResponse
    {
        $id = $request->query->get('i');
        $entityManager = $this->getDoctrine()->getManager();
        $user = $request->attributes->get('user');

        
        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->find($id);

        if ($article->getUsers()->getId() === $user->getId()) {
            $entityManager->remove($article);
    
            $entityManager->flush();
        } else {
            throw $this->createNotFoundException(
                'No article found for id '.$id
            );
        }

        return new JsonResponse(['result' => 'ok', 'data' => ['message' => 'Deleted new article with id '.$article->getId()]]);
    }

    /**
    * @Route("/api/article/list", name="list-articles")
    * @param Request $request
    */
    public function list(Request $request, SerializerInterface $serializer): JsonResponse
    {
        $post_data = json_decode($request->getContent(), true);
        $entityManager = $this->getDoctrine()->getManager();
        $pre = $post_data['pre'];
        $page = $post_data['pageNumber'];
        $id = $post_data['id'];
        if($pre == "") {
            $pre = NULL;
        }
        if($page == NULL) {
            $page = 0;
        }
        if($id == NULL) {
            $page = -1;
        }
        $orderBy = $post_data['orderby'];

        $orderBystring = "";

        if($orderBy != NULL) {
            $orderBystring = $orderBystring.'ORDER BY ';
            switch($orderBy) {
                case 'c':
                    $orderBystring = $orderBystring.'u.username ASC';
                    break;
                case 'u':
                    $orderBystring = $orderBystring.'a.createdAt DESC';
                    break;
                case 't':
                    $orderBystring = $orderBystring.'a.name ASC';
                    break;
                default:
                    $orderBystring = $orderBystring.'a.createdAt DESC';
                    break;
            }
        }
        
        $query = $entityManager->createQuery(
            "SELECT a
            FROM App\Entity\Article a
            INNER JOIN a.users u
            LEFT JOIN a.tags t
            WHERE (a.name LIKE :pre OR a.content LIKE :pre OR :pre LIKE '')
            AND (t.id = :id or :id = -1) ".$orderBystring
        )->setParameter('id', $id)->setParameter('pre', "%".$pre."%");

        // returns an array of Product objects
        $articles = $query->getResult();
        
        $json = $serializer->serialize($articles, 'json', ['groups' => ['user','article','reaction','tag', 'comment'] ]);
        return new JsonResponse(['result' => 'ok', 'data' => ['articles' => json_decode($json)]]);
    }
}
