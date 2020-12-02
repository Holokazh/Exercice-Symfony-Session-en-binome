<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Training;
use App\Form\ModulesType;

use App\Form\SessionType;
use App\Form\TrainingType;
use App\Repository\SessionRepository;
use App\Repository\TrainingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SessionController extends AbstractController
{

    /////-- SESSION --/////

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

    /**
     * @Route("/directors/session/add", name="session_add")
     * @Route("/directors/session/{id}/edit", name="session_edit")
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
     * @Route("/directors/session/{id}/delete", name="session_delete")
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

    /////-- TRAINING --/////

    /**
     * @Route("/training/listAllTrainings", name="listAllTrainings")
     */
    public function listAllTrainings(): Response
    {
        $trainings = $this->getDoctrine()
            ->getRepository(Training::class)
            ->findAll();

        return $this->render('training/index.html.twig', [
            'trainings' => $trainings,
        ]);
    }

    /**
     * @Route("/directors/training/add", name="training_add")
     * @Route("/directors/training/{id}/edit", name="training_edit")
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
            'training' => $training->getName()
        ]);
    }

    /**
     * @Route("/directors/training/{id}/delete", name="training_delete")
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
     * @Route("/directors/training/addDuration/{id}", name="add_duration")
     */
    public function addModuleToTraining(Training $training, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(ModulesType::class, $training);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($training);
            $manager->flush();

            return $this->redirectToRoute('listAllTrainings');
        }

        return $this->render('duration/addDuration.html.twig', [
            'formModuleToTraining' => $form->createView(),
            'training' => $training
        ]);
    }

    // /**
    //  * @Route("/training/search", name="training_search" , methods={"GET","POST"})
    //  */
    // public function searchTraining(Request $request)
    // {
    //     $form = $this->createFormBuilder()->add('search', SearchType::class)->getForm();
    //     $form->handleRequest($request);
    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $data = $form->get('search')->getData();
    //         $trainings = $this->getDoctrine()->getRepository(Training::class)->search($data);
    //         return $this->render('training/search.html.twig', [
    //             'trainings' => $trainings
    //         ]);
    //     }

    //     return $this->render('home/index.html.twig', [
    //         'form' => $form->createView()
    //     ]);
    // }
}
