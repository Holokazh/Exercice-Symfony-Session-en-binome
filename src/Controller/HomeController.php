<?php

namespace App\Controller;

use App\Entity\Training;
use App\Repository\TrainingRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home" , methods={"GET","POST"})
     */
    public function searchTraining(Request $request, TrainingRepository $trainingRepository)
    {
        $form = $this->createFormBuilder()->add('search', SearchType::class, ['label' => 'Recherche'])->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $trainings = $trainingRepository->search($data['search']);
            var_dump($trainings);
            return $this->render('training/search.html.twig', [
                'trainings' => $trainings
            ]);
        }

        return $this->render('home/index.html.twig', [
            'formSearchTraining' => $form->createView()
        ]);
    }
}
