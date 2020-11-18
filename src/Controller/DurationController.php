<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Duration;
use App\Repository\DurationRepository;

class DurationController extends AbstractController
{
    /**
     * @Route("/duration", name="duration")
     */
    public function index(): Response
    {
        return $this->render('duration/index.html.twig', [
            'controller_name' => 'DurationController',
        ]);
    }
}
