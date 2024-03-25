<?php

namespace App\Controller;

use App\Entity\Inscription;
use App\Form\InscriptionModifierType;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class InscriptionController extends AbstractController
{
    /*#[Route('/inscription', name: 'app_inscription')]*/
    public function index(): Response
    {
        return $this->render('inscription/index.html.twig', [
            'controller_name' => 'InscriptionController',
        ]);
    }

    public function listerInscription(ManagerRegistry $doctrine){

        $repository = $doctrine->getRepository(Inscription::class);

        $inscriptions= $repository->findAll();
        return $this->render('inscription/lister.html.twig', [
            'pInscription' => $inscriptions,]);

    }

    public function consulterInscription(ManagerRegistry $doctrine, int $id){

        $inscription = $doctrine->getRepository(Inscription::class)->find($id);

        if (!$inscription) {
            throw $this->createNotFoundException(
                'Aucune inscription trouvé avec le numéro '.$id
            );
        }

        //return new Response('Inscription : '.$inscription->getNom());
        return $this->render('inscription/consulter.html.twig', [
            'inscription' => $inscription,]);
    }

    public function ajouterInscription(Request $request, EntityManagerInterface $entityManager): Response
    {
        $inscription = new Inscription();
        $form = $this->createForm(InscriptionType::class, $inscription);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($inscription);
            $entityManager->flush();

            $this->addFlash('success', 'Inscription créé avec succès!');
            return $this->redirectToRoute('inscriptionLister');
        }

        return $this->render('inscription/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function modifierInscription(ManagerRegistry $doctrine, $id, Request $request){

        $inscription = $doctrine->getRepository(Inscription::class)->find($id);

        if (!$inscription) {
            throw $this->createNotFoundException('Aucune inscription trouvé avec le numéro '.$id);
        }
        else
        {
            $form = $this->createForm(InscriptionModifierType::class, $inscription);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $inscription = $form->getData();
                $entityManager = $doctrine->getManager();
                $entityManager->persist($inscription);
                $entityManager->flush();
                return $this->redirectToRoute("inscriptionLister");
            }
            else{
                return $this->render('inscription/ajouter.html.twig', array('form' => $form->createView(),));
            }
        }
    }
}
