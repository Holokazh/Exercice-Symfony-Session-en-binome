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

    /////-- CATEGORY --/////

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
     * @Route("/category/listAllCategories", name="listAllCategories")
     */
    public function listAllCategories(): Response
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        return $this->render('category/list.html.twig', [
            'categories' => $categories,
        ]);
    }

    /////-- MODULE --/////

    /**
     * @Route("/module", name="module")
     */
    public function indexModule(): Response
    {
        return $this->render('module/index.html.twig', [
            'controller_name' => 'ProgramController',
        ]);
    }

    /**
     * @Route("/module/listAllModules", name="listAllModules")
     */
    public function listAllModules(): Response
    {
        $modules = $this->getDoctrine()
            ->getRepository(Module::class)
            ->findAll();

        return $this->render('module/list.html.twig', [
            'modules' => $modules,
        ]);
    }
}
