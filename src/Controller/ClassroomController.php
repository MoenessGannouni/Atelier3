<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ClassroomRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Classroom;
use App\Form\AjouterClassroomType;



use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class ClassroomController extends AbstractController
{
    #[Route('/classroom', name: 'app_classroom')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine->getRepository(Classroom::class);
        $classrooms = $repo->findAll();

        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
            'classrooms'=>$classrooms
        ]);
    }

    #[Route('/addClassroom', name: 'add_classroom')]
    public function addFormMaker(Request $request){
        $classroom = new Classroom();

        $form = $this->createForm(AjouterClassroomType::class,$classroom);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($classroom);
            $em->flush();
            return $this->redirectToRoute("app_classroom");
        } else{
            return $this->render("classroom/addC.html.twig",array('formA'=>$form->createView()));
        }

    }

    #[Route('/updateClassroom/{id}', name: 'update_classroom')]
    public function update($id, Request $request): Response
    {
        $classroom = $this->getDoctrine()->getRepository(Classroom::class)->find($id);
        $form = $this->createForm(AjouterClassroomType::class, $classroom);
        $form->add('Modifier', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this-> redirectToRoute("app_classroom");
        }else {
            return $this->render("classroom/updateC.html.twig",array('formA'=>$form->createView()));
        } 
    }

    #[Route('/deleteClassroom/{id}', name: 'delete_classroom')]
    public function delete($id, Request $request): Response
    {
        $classroom = $this->getDoctrine()->getRepository(Classroom::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($classroom);
        $em->flush();
        return $this-> redirectToRoute("app_classroom");
    }

}
