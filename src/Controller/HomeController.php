<?php

namespace App\Controller;

use App\Entity\Training;
use App\Form\SearchTrainingType;
use App\Repository\TrainingRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function searchTraining(Request $request, TrainingRepository $trainingRepository)
    {
        $form = $this->createForm(SearchTrainingType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->get('name')->getData();
            $trainings = $trainingRepository->search($data);
            return $this->render('training/search.html.twig', [
                'trainings' => $trainings
            ]);
        }

        return $this->render('home/index.html.twig', [
            'formSearchTraining' => $form->createView()
        ]);
    }
}
