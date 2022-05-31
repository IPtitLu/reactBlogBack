<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class PostController extends AbstractController
{
    private EntityManager $entityManager;
    private Security $security;
    private PostRepository $postRepository;

    public function  __construct(EntityManager $entityManager, Security $security, PostRepository $postRepository)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
        $this->postRepository = $postRepository;
    }

    #[Route(path: '/create-post', name: 'app_create_post')]
    public function create(Request $request): void
    {
        if($_COOKIE["userId"] == $this->security->getUser()) {
            $post = new Post();
            $post->setTitle($request->request->get('title'))
                ->setContent($request->request->get('title'))
                ->setUser($this->security->getUser());

            try {
                $this->entityManager->persist($post);
                $this->entityManager->flush();
            } catch (ORMException $e) {  echo $e;
            }
        }
    }

    #[Route(path: '/posts', name: 'app_posts')]
    public function getAll(Request $request) {
        return $this->postRepository->findAll();
    }
}
