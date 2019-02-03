<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/newUser", name="newUser")
     */
    public function new()
    {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to your action: index(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getManager();

        $user = new User();
        $user->setName('Fatma');
        $user->setEmail('fatma212@hotmail.fr');
        $user->setPassword('$2y$12$mjze21P5MgF5PfRB8vYfD.sCmwWVqrFBtcEdqDO8YDnlA4DxS1vXC');
        $user->setRoles(array('ROLE_ADMIN'));

        // tell Doctrine you want to (eventually) save the User (no queries yet)
        $entityManager->persist($user);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('un nouvel user est crée avec id '.$user->getId());
    }
}
