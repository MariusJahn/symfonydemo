<?php

namespace App\Controller;

use App\Form\TaskType;
use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormController extends AbstractController
{
    #[Route('/form', name: 'form')]
    public function new(Request $request): Response
    {
        $task = new Task();

        //$form = $this->createForm(TaskType::class, $task);

        $dateIsRequired = true;

        $form = $this->createForm(TaskType::class, $task, [
            'require_date' => $dateIsRequired,
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $task = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($task);
            // $entityManager->flush();

            return $this->redirectToRoute('task_success');
        }

        return $this->render('form/index.html.twig', [
            'task_form' => $form->createView(),
        ]);

    }




}
