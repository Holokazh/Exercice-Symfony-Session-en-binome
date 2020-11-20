<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Entity\Module;
use App\Repository\ModuleRepository;

class ProgramController extends AbstractController
{
    /**
     * @Route("/category", name="category")
     */
    public function index(): Response
    {
        return $this->render('category/index.html.twig', [
            'controller_name' => 'ProgramController',
        ]);
    }

        /**
     * @Route("/module", name="module")
     */
    public function indexModule(): Response
    {
        return $this->render('module/index.html.twig', [
            'controller_name' => 'ProgramController',
        ]);
    }
}
