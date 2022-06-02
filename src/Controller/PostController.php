<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface as EntityManager;
use Doctrine\ORM\Exception\ORMException;
use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class PostController extends AbstractController
{
    private EntityManager $entityManager;
    private Security $security;
    private PostRepository $postRepository;
    private UserRepository $userRepository;

    public function  __construct(EntityManager $entityManager, Security $security, PostRepository $postRepository,
                                UserRepository $userRepository)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;
    }

    #[Route(path: '/api/create-post', name: 'app_api_create_post')]
    public function create(Request $request): void
    {
        $data = json_decode($request->getContent(), true);

        $tokenParts = explode(".", $data['token']);
        $tokenPayload = base64_decode($tokenParts[1]);
        $jwtPayload = json_decode($tokenPayload);
        $username = $jwtPayload->username;

        $user = $this->userRepository->findBy(['email' => $username]);

        $post = new Post();

        $post->setTitle($data['title'])
                ->setContent($data['title'])
                ->setUser($user[0]);

            try {
                $this->entityManager->persist($post);
                $this->entityManager->flush();

                echo 'success';
                die;
            } catch (ORMException $e) {  echo $e;
            }
    }

//    #[Route(path: '/posts', name: 'app_api_posts')]
//    public function getAll(): array
//    {
//        return $this->postRepository->findAll();
//    }
}
