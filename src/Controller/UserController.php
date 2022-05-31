<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
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

    #[Route(path: '/register', name: 'app_register')]
    public function Register(Request $request): void
    {

        $user = new User();
        $user->setEmail($request->request->get('email'))
            ->setPassword($this->hasher->hashPassword($user, $request->request->get('password')));

        try {
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        } catch (ORMException $e) {
            echo $e;
        }
    }
}
