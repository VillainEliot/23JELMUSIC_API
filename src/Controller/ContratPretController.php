<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Entity\Maison;
use App\Form\ContratPretType;
use App\Form\ContratPretModifierType;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\ContratPret;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class ContratPretController extends AbstractController
{
    //#[Route('/contrat/pret', name: 'app_contrat_pret')]
    public function index(): Response
    {
        return $this->render('contratPret/index.html.twig', [
            'controller_name' => 'ContratPretController',
        ]);
    }

    public function listerContratPret(ManagerRegistry $doctrine){

        $repository = $doctrine->getRepository(ContratPret::class);

        $contratPrets= $repository->findAll();
        return $this->render('contratPret/lister.html.twig', [
            'pContratPret' => $contratPrets,]);

    }

    public function consulterContratPret(ManagerRegistry $doctrine, int $id){

        $contratPret= $doctrine->getRepository(ContratPret::class)->find($id);

        if (!$contratPret) {
            throw $this->createNotFoundException(
                'Aucun ContratPret trouvé avec le numéro '.$id
            );
        }

        //return new Response('ContratPret : '.$ContratPret->getNom());
        return $this->render('contratPret/consulter.html.twig', [
            'contratPret' => $contratPret,]);
    }

    public function ajouterContratPret(Request $request, PersistenceManagerRegistry $doctrine):Response{

        $contratPret = new contratPret();
        $form = $this->createForm(ContratPretType::class, $contratPret);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $contratPret = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($contratPret);
            $entityManager->flush();

            $this->addFlash('success', 'Contrat de pret created successfully!');
            return $this->redirectToRoute('ContratPretlister');
        }
        else
        {
            return $this->render('contratPret/ajouter.html.twig', array('form' => $form->createView(),));
        }
    }

    public function modifierContratPret(ManagerRegistry $doctrine, $id, Request $request){

        //récupération de l'contrat pret dont l'id est passé en paramètre
        $contratPret = $doctrine->getRepository(ContratPret::class)->find($id);

        $repository = $doctrine->getRepository(ContratPret::class);
        $contratPrets = $repository->findAll();

        if (!$contratPret) {
            throw $this->createNotFoundException('Aucun contrat pret trouvé avec le numéro '.$id);
        }
        else
        {
            $form = $this->createForm(ContratPretModifierType::class, $contratPret);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $contratPret = $form->getData();
                $entityManager = $doctrine->getManager();
                $entityManager->persist($contratPret);
                $entityManager->flush();
                return $this->render('contratPret/consulter.html.twig', ['contratPret' => $contratPret, 'pContratPrets' => $contratPrets]);
            }
            else{
                return $this->render('contratPret/modifier.html.twig', array('form' => $form->createView(),));
            }
        }
    }




}
