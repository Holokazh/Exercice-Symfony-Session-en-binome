<?php

namespace App\Controller;

use App\Entity\Module;
use App\Entity\Category;
use App\Repository\ModuleRepository;
use App\Form\CategoryType;

use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    /**
     * @Route("/add", name="category_add")
     * @Route("/{id}/edit", name="category_edit")
     */
    public function new_update(Category $category = null, Request $request, EntityManagerInterface $manager)
    {
        if (!$category) {
            $category = new Category();
        }

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($category);
            $manager->flush();

            return $this->redirectToRoute('listAllCategories');
        }

        return $this->render('category/add_edit.html.twig', [
            'formCategory' => $form->createView(),
            'editMode' => $category->getId() !== null,
            'category' => $category->getName()
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
