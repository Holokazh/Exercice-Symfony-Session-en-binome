<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Training;
use App\Form\SessionType;

use App\Form\TrainingType;
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

        return $this->render('session/index.html.twig', [
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
     * @Route("/training/add", name="training_add")
     * @Route("/training/{id}/edit", name="training_edit")
     */
    public function new_update(Training $training = null, Request $request, EntityManagerInterface $manager)
    {
        if (!$training) {
            $training = new Training();
        }

        $form = $this->createForm(TrainingType::class, $training);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($training);
            $manager->flush();

            return $this->redirectToRoute('listAllTrainings');
        }

        return $this->render('training/add_edit.html.twig', [
            'formTraining' => $form->createView(),
            'editMode' => $training->getId() !== null,
            'training' => $training->getFirstName()
        ]);
    }

    /**
     * @Route("/training/{id}/delete", name="training_delete")
     */
    public function deletetraining(Training $training = null, EntityManagerInterface $manager)
    {
        $manager->remove($training);
        $manager->flush();

        return $this->redirectToRoute('listAllTrainings');
    }

    /**
     * @Route("/training/{id}/show", name="training_show")
     */
    public function show(Training $training): Response
    {
        return $this->render('training/show.html.twig', ['training' => $training]);
    }

    /**
     * @Route("/session/add", name="session_add")
     * @Route("/session/{id}/edit", name="session_edit")
     */
    public function new_updateSession(Session $session = null, Request $request, EntityManagerInterface $manager)
    {
        if (!$session) {
            $session = new Session();
        }

        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($session);
            $manager->flush();

            return $this->redirectToRoute('listAllSessions');
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
    public function showSession(Session $session): Response
    {
        return $this->render('session/show.html.twig', ['session' => $session]);
    }
}
