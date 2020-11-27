<?php

namespace App\Controller;

use App\Entity\Module;
use App\Entity\Category;
use App\Form\ModuleType;
use App\Form\CategoryType;

use App\Repository\ModuleRepository;
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
     * @Route("/directors/category/listAllCategories", name="listAllCategories")
     */
    public function listAllCategories(): Response
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/directors/category/add", name="category_add")
     * @Route("/directors/category/{id}/edit", name="category_edit")
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

    /**
     * @Route("/directors/category/{id}/delete", name="category_delete")
     */
    public function deleteCategory(Category $category = null, EntityManagerInterface $manager)
    {
        $manager->remove($category);
        $manager->flush();

        return $this->redirectToRoute('listAllCategories');
    }

    /**
     * @Route("/directors/category/{id}/show", name="category_show")
     */
    public function show(Category $category): Response
    {
        return $this->render('category/show.html.twig', ['category' => $category]);
    }


    /////-- MODULE --/////

    /**
     * @Route("/directors/module/listAllModules", name="listAllModules")
     */
    public function listAllModules(): Response
    {
        $modules = $this->getDoctrine()
            ->getRepository(Module::class)
            ->findAll();

        return $this->render('module/index.html.twig', [
            'modules' => $modules,
        ]);
    }

    /**
     * @Route("/directors/module/add", name="module_add")
     * @Route("/directors/module/{id}/edit", name="module_edit")
     */
    public function new_updateModule(Module $module = null, Request $request, EntityManagerInterface $manager)
    {
        if (!$module) {
            $module = new Module();
        }

        $form = $this->createForm(ModuleType::class, $module);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($module);
            $manager->flush();

            return $this->redirectToRoute('listAllModules');
        }

        return $this->render('module/add_edit.html.twig', [
            'formModule' => $form->createView(),
            'editMode' => $module->getId() !== null,
            'module' => $module
        ]);
    }

    /**
     * @Route("/directors/module/{id}/delete", name="module_delete")
     */
    public function deleteModule(Module $module = null, EntityManagerInterface $manager)
    {
        $manager->remove($module);
        $manager->flush();

        return $this->redirectToRoute('listAllModules');
    }
}
