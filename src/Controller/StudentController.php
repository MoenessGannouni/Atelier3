<?php

namespace App\Controller;

use App\Repository\StudentRepository; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Student;

class StudentController extends AbstractController
{
  /*  #[Route('/student', name: 'app_student')]
    public function index(StudentRepository $repo): Response
    {
        $students = $repo->findAll();
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
            'students'=>$students
        ]);
    } */

    #[Route('/student', name: 'app_student')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine->getRepository(Student::class);
        $students = $repo->findAll();

        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
            'students'=>$students
        ]);
    }

    #[Route('/deleteStudent/{id}', name: 'delete_student')]
    public function deleteStudent($id,ManagerRegistry $doctrine){
        $student = $doctrine->getRepository(Student::class)->find($id);
        $em = $doctrine->getManager();
        $em->remove($student); //Pour supprimer
        $em->flush(); //pour envoyer la requete

        return $this->redirectToRoute('app_student');

    }

    #[Route('/addStudent', name: 'add_student')]
    public function addStudent(ManagerRegistry $doctrine){
        $student = new Student();
        $student->setName('test');
        $student->setEmail('test@t.t');

        $em = $doctrine->getManager();
        $em->persist($student);  //Pour ajouter 
        $em->flush(); //pour envoyer la requete

        return $this->redirectToRoute('app_student');

    }

    #[Route('/updateStudent/{id}', name: 'update_student')]
    public function updateStudent($id,ManagerRegistry $doctrine){
        $student = $doctrine->getRepository(Student::class)->find($id);
        $student->setName("SSSSS");
        $em = $doctrine->getManager();
       // $em->persist($student) on n'a pas besoin 
        $em->flush(); //pour envoyer la requete

        return $this->redirectToRoute('app_student');

    }
}
