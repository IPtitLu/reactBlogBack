<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface as EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private EntityManager $entityManager;
    private UserPasswordHasherInterface $hasher;

    public function  __construct(EntityManager $entityManager, UserPasswordHasherInterface $hasher)
    {
        $this->entityManager = $entityManager;
        $this->hasher = $hasher;
    }

    #[Route(path: '/api/register', name: 'app_api_register')]
    public function Register(Request $request): void
    {
        $data = json_decode($request->getContent(), true);

        $user = new User();
        $user->setEmail($data['email'])
            ->setPassword($this->hasher->hashPassword($user, $data['password']));

        try {
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            echo 'success';
            die;
        } catch (ORMException $e) {
            echo $e;
        }
    }
}
