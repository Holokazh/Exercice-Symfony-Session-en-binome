<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Session;
use App\Repository\SessionRepository;
use App\Entity\Training;
use App\Repository\TrainingRepository;

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
}
