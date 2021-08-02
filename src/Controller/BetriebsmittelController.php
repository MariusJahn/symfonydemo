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


        $betriebsmittel = $repository->findAll();

        if (!$betriebsmittel) {

            $logger->error('Keine Betriebsmittel gefunden');

            throw $this->createNotFoundException(
                'No betriebsmittel found'
            );
        }

        $logger->info('Alle Einträge der Tabelle wurden geladen');

        return $this->render('betriebsmittel/index.html.twig', [
            'controller_name' => 'TabellenController',
            'betriebsmittel' => $betriebsmittel
        ]);
    }

    #[Route('/betriebsmittel/{id}', name: 'show_betriebsmittel')]
    public function show(Betriebsmittel $betriebsmittel, LoggerInterface $logger): Response
    {

        // Mit composer require sensio/framework-extra-bundle kann man direkt auf das Betriebsmittel zugreifen
        // vorher musste man die id selbst aufrufen und den 404 error erzeugen.

        return new Response('Check out this great betriebsmittel: '.$betriebsmittel->getName());
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

            return $this->redirectToRoute('betriebsmittel_success');
        }

        return $this->render('betriebsmittel/betriebsmittelErstellen.html.twig', [
            'betriebsmittel_form' => $form->createView(),
        ]);
    }


}
