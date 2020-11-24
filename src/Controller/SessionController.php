<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Training;
use App\Form\SessionType;

use App\Repository\SessionRepository;
use App\Repository\TrainingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SessionController extends AbstractController
{

    /////-- SESSION --/////

    /**
     * @Route("/session", name="session")
     */
    public function index(): Response
    {
        return $this->render('session/index.html.twig', [
            'controller_name' => 'SessionController',
        ]);
    }

    /**
     * @Route("/session/listAllSessions", name="listAllSessions")
     */
    public function listAllSessions(): Response
    {
        $sessions = $this->getDoctrine()
            ->getRepository(Session::class)
            ->findAll();

        return $this->render('session/list.html.twig', [
            'sessions' => $sessions,
        ]);
    }


    /////-- TRAINING --/////

    /**
     * @Route("/training", name="training")
     */
    public function indexTraining(): Response
    {
        return $this->render('training/index.html.twig', [
            'controller_name' => 'SessionController',
        ]);
    }

        /**
     * @Route("/training/listAllTrainings", name="listAllTrainings")
     */
    public function listAllTrainings(): Response
    {
        $trainings = $this->getDoctrine()
            ->getRepository(Training::class)
            ->findAll();

        return $this->render('training/list.html.twig', [
            'trainings' => $trainings,
        ]);
    }

    /**
     * @Route("/session/add", name="session_add")
     * @Route("/session/{id}/edit", name="session_edit")
     */
    public function new_update(Session $session = null, Request $request, EntityManagerInterface $manager)
    {
        if (!$session) {
            $session = new Session();
        }

        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($session);
            $manager->flush();

            return $this->redirectToRoute('listAllCategories');
        }

        return $this->render('session/add_edit.html.twig', [
            'formSession' => $form->createView(),
            'editMode' => $session->getId() !== null,
            'session' => $session
        ]);
    }

    /**
     * @Route("/session/{id}/delete", name="session_delete")
     */
    public function deleteSession(Session $session = null, EntityManagerInterface $manager)
    {
        $manager->remove($session);
        $manager->flush();

        return $this->redirectToRoute('listAllCategories');
    }

    /**
     * @Route("/session/{id}/show", name="session_show")
     */
    public function show(Session $session): Response
    {
        return $this->render('session/show.html.twig', ['session' => $session]);
    }
}
