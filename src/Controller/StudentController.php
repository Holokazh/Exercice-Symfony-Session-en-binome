<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\StudentRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StudentController extends AbstractController
{
    /**
     * @Route("/student", name="student")
     */
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }

    /**
     * @Route("/student/listAllStudents", name="listAllStudents")
     */
    public function listAllStudents(): Response
    {
        $students = $this->getDoctrine()
            ->getRepository(Student::class)
            ->findAll();

        return $this->render('student/list.html.twig', [
            'students' => $students,
        ]);
    }

    /**
     * @Route("/student/add", name="student_add")
     * @Route("/student/{id}/edit", name="student_edit")
     */
    public function new_update(Student $student = null, Request $request, EntityManagerInterface $manager)
    {
        if (!$student) {
            $student = new Student();
        }

        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($student);
            $manager->flush();

            return $this->redirectToRoute('listAllStudents');
        }

        return $this->render('student/add_edit.html.twig', [
            'formStudent' => $form->createView(),
            'editMode' => $student->getId() !== null,
            'student' => $student->getFirstName()
        ]);
    }

    /**
     * @Route("/student/{id}/delete", name="student_delete")
     */
    public function deletestudent(Student $student = null, EntityManagerInterface $manager)
    {
        $manager->remove($student);
        $manager->flush();

        return $this->redirectToRoute('listAllStudents');
    }

    /**
     * @Route("/student/{id}/show", name="student_show")
     */
    public function show(Student $student): Response
    {
        return $this->render('student/show.html.twig', ['student' => $student]);
    }
}
