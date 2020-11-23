<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/user/listAllUsers", name="listAllUsers")
     */
    public function listAllUsers(): Response
    {
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();

        return $this->render('user/list.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/user/{id}/delete", name="user_delete")
     */
    public function deleteuser(User $user = null, EntityManagerInterface $manager)
    {
        $manager->remove($user);
        $manager->flush();

        return $this->redirectToRoute('listAllUsers');
    }
}
