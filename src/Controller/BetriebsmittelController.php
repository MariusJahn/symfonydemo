<?php

namespace App\Controller;

use App\Entity\Betriebsmittel;
use App\Form\BetriebsmittelType;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BetriebsmittelController extends AbstractController
{
    /**
     * Anzeigen aller Betriebsmittel
     *
     * @param LoggerInterface $logger
     * @return Response
     */
    #[Route('/betriebsmittel', name: 'betriebsmittel')]
    public function index(LoggerInterface $logger): Response
    {
        $repository = $this->getDoctrine()
            ->getRepository(Betriebsmittel::class);


        $darfSehen = true;

        $betriebsmittel = $repository->findBy(array(),['id' => 'ASC']);

        if (!$betriebsmittel) {

            $logger->error('Keine Betriebsmittel gefunden');

            throw $this->createNotFoundException(
                'No betriebsmittel found'
            );
        }

        $logger->info('Alle Einträge der Tabelle wurden geladen');

        return $this->render('betriebsmittel/index.html.twig', [
            'controller_name' => 'BetriebsmittelContoller',
            'betriebsmittel' => $betriebsmittel,
            'darfSehen' => $darfSehen,
        ]);
    }

    #[Route('/betriebsmittel/{id}', name: 'show_betriebsmittel')]
    public function show(Request $request, LoggerInterface $logger, $id): Response
    {

        $data = $this->getDoctrine()->getRepository(Betriebsmittel::class)->find($id);
        $em = $this->getDoctrine()->getManager();

        // Mit composer require sensio/framework-extra-bundle kann man direkt auf das Betriebsmittel zugreifen
        // vorher musste man die id selbst aufrufen und den 404 error erzeugen.

        //return new Response('Schau dir dieses Betriebsmittel an: '.$data->getName());

        return $this->render('betriebsmittel/betriebsmittelAnzeigen.html.twig', [
            'controller_name' => 'BetriebsmittelContoller',
            'betriebsmittel' => $data,
        ]);
    }

    #[Route('/betriebsmittel', name: 'betriebsmittel_success')]

    #[Route('/betriebsmittelErstellen', name: 'create_betriebsmittel')]
    public function new(Request $request): Response
    {
        $betriebsmittel = new Betriebsmittel();

        $form = $this->createForm(BetriebsmittelType::class, $betriebsmittel, [

        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $betriebsmittel = $form->getData();

            // you can fetch the EntityManager via $this->getDoctrine()
            // or you can add an argument to the action: createProduct(EntityManagerInterface $entityManager)
            $entityManager = $this->getDoctrine()->getManager();

            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $entityManager->persist($betriebsmittel);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Das Betriebsmittel wurde erfolgreich erstellt!'
            );

            return $this->redirectToRoute('betriebsmittel_success');
        }

        return $this->render('betriebsmittel/betriebsmittelErstellen.html.twig', [
            'create_form' => $form->createView(),
        ]);
    }

    #[Route('/betriebsmittel/update/{id}', name: 'update_betriebsmittel')]
    public function update(Request $request, $id): Response {

        $betriebsmittel = $this->getDoctrine()->getRepository(Betriebsmittel::class)->find($id);
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(BetriebsmittelType::class, $betriebsmittel);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $betriebsmittel = $form->getData();

            $em->persist($betriebsmittel);

            $em->flush();

            $this->addFlash(
                'notice',
                'Das Betriebsmittel wurde erfolgreich aktualisiert!'
            );

            return $this->redirectToRoute('betriebsmittel_success');

        }

        return $this->render('betriebsmittel/betriebsmittelAktualisieren.html.twig', [
            'update_form' => $form->createView(),
        ]);

    }

    #[Route('/betriebsmittel/delete/{id}', name: 'delete_betriebsmittel')]
    public function delete(Request $request, $id): Response {

        $betriebsmittel = $this->getDoctrine()->getRepository(Betriebsmittel::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($betriebsmittel);
        $em->flush();

        $this->addFlash('notice', 'Das Betriebsmittel wurde erfolgreich gelöscht.');

        return $this->redirectToRoute('betriebsmittel_success');

    }


}
