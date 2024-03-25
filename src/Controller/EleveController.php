<?php

namespace App\Controller;

use App\Form\EleveModifierType;
use App\Form\EleveType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Proxies\__CG__\App\Entity\Eleve;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EleveController extends AbstractController
{
    /*#[Route('/eleve', name: 'app_eleve')]*/
    public function index(): Response
    {
        return $this->render('eleve/index.html.twig', [
            'controller_name' => 'EleveController',
        ]);
    }

    public function listerEleve(ManagerRegistry $doctrine){

        $repository = $doctrine->getRepository(Eleve::class);

        $eleves= $repository->findAll();
        return $this->render('eleve/lister.html.twig', [
            'pEleve' => $eleves,]);

    }

    public function consulterEleve(ManagerRegistry $doctrine, int $id){

        $eleve= $doctrine->getRepository(Eleve::class)->find($id);

        if (!$eleve) {
            throw $this->createNotFoundException(
                'Aucun eleve trouvé avec le numéro '.$id
            );
        }

        //return new Response('Eleve : '.$eleve->getNom());
        return $this->render('eleve/consulter.html.twig', [
            'eleve' => $eleve,]);
    }

    public function ajouterEleve(Request $request, EntityManagerInterface $entityManager): Response
    {
        $eleve = new Eleve();
        $form = $this->createForm(EleveType::class, $eleve);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($eleve);
            $entityManager->flush();

            $this->addFlash('success', 'Eleve créé avec succès!');
            return $this->redirectToRoute('eleveLister');
        }

        return $this->render('eleve/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function modifierEleve(ManagerRegistry $doctrine, $id, Request $request){

        $eleve = $doctrine->getRepository(Eleve::class)->find($id);

        if (!$eleve) {
            throw $this->createNotFoundException('Aucune eleve trouvé avec le numéro '.$id);
        }
        else
        {
            $form = $this->createForm(EleveModifierType::class, $eleve);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $eleve = $form->getData();
                $entityManager = $doctrine->getManager();
                $entityManager->persist($eleve);
                $entityManager->flush();
                return $this->redirectToRoute("eleveLister");
            }
            else{
                return $this->render('eleve/ajouter.html.twig', array('form' => $form->createView(),));
            }
        }
    }
}
