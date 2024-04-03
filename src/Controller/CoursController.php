<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Form\CoursModifierType;
use App\Form\CoursType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class CoursController extends AbstractController
{
    //#[Route('/cours', name: 'app_cours')]
    public function index(): Response
    {
        return $this->render('cours/index.html.twig', [
            'controller_name' => 'CoursController',
        ]);
    }

    //#[Route('/cours/lister', name: 'coursLister')]
    public function listerCours(ManagerRegistry $doctrine, SerializerInterface $serializer): Response
    {

        $repository = $doctrine->getRepository(Cours::class);
        $cours = $repository->findAll();

        // Tri des cours par type d'instrument, jour (trié par ID) et heure
        usort($cours, function ($a, $b) {
            $dayIdA = $a->getJours()->getId();
            $dayIdB = $b->getJours()->getId();

            if ($dayIdA === $dayIdB) {
                $heureDebutA = $a->getHeureDebut()->getTimestamp();
                $heureDebutB = $b->getHeureDebut()->getTimestamp();
                return $heureDebutA - $heureDebutB;
            }

            return $dayIdA - $dayIdB;
        });

        // Calcul du nombre de cours par type d'instrument
        $countByTypeInstrument = [];
        foreach ($cours as $c) {
            $typeInstruments = $c->getTypeInstruments()->getLibelle();
            $countByTypeInstrument[$typeInstruments] = ($countByTypeInstrument[$typeInstruments] ?? 0) + 1;
        }

        $serializerController = new Serializer($serializer);
        $ignAttr = ['cours', 'instrument', 'instruments', 'contratprets', 'eleves'];
        return $serializerController->serializeObject($cours, $ignAttr);

//        return $this->render('cours/lister.html.twig', [
//            'pCours' => $cours,
//            'countByTypeInstrument' => $countByTypeInstrument,
//        ]);
    }


    //#[Route('/cours/consulter/{id}', name: 'coursConsulter')]
    public function consulterCours(ManagerRegistry $doctrine, int $id, SerializerInterface $serializer){

        $cours= $doctrine->getRepository(Cours::class)->find($id);

        if (!$cours) {
            throw $this->createNotFoundException(
                'Aucun cours trouvé avec le numéro '.$id
            );
        }

        $eleveInscrits = $cours->getInscriptions();

        $serializerController = new Serializer($serializer);
        $ignAttr = ['cours', 'instrument', 'instruments', 'contratprets', 'eleves'];
        return $serializerController->serializeObject($cours, $ignAttr);

        //return new Response('cours : '.$cours->getLibelle());
//        return $this->render('cours/consulter.html.twig', [
//            'cours' => $cours,
//            'eleveInscrits' => $eleveInscrits,]);
    }

    //#[Route('/cours/ajouter', name: 'coursAjouter')]
    public function ajouterCours(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cours = new Cours();
        $form = $this->createForm(CoursType::class, $cours);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($cours);
            $entityManager->flush();

            $this->addFlash('success', 'Cours créé avec succès!');
            return $this->redirectToRoute('coursLister');
        }

        return $this->render('cours/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function modifierCours(ManagerRegistry $doctrine, $id, Request $request){

        $cours = $doctrine->getRepository(Cours::class)->find($id);

        //$repository = $doctrine->getRepository(Cours::class);
        //$cours = $repository->findAll();

        if (!$cours) {
            throw $this->createNotFoundException('Aucun cours trouvé avec le numéro '.$id);
        }
        else
        {
            $form = $this->createForm(CoursModifierType::class, $cours);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $cours = $form->getData();
                $entityManager = $doctrine->getManager();
                $entityManager->persist($cours);
                $entityManager->flush();
                return $this->redirectToRoute("coursLister");
            }
            else{
                return $this->render('cours/ajouter.html.twig', array('form' => $form->createView(),));
            }
        }
    }
}