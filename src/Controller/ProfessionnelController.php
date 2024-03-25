<?php

namespace App\Controller;

use App\Form\ProfessionnelAjouterType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Professionnel;
use App\Form\ProfessionnelModifierType;

class ProfessionnelController extends AbstractController
{
    /*#[Route('/professionnel', name: 'app_professionnel')]
    public function index(): Response
    {
        return $this->render('professionnel/index.html.twig', [
            'controller_name' => 'ProfessionnelController',
        ]);
    }*/

    public function listerProfessionnel(ManagerRegistry $doctrine)
    {

        $repository = $doctrine->getRepository(Professionnel::class);

        $professionnel = $repository->findAll();
        return $this->render('professionnel/lister.html.twig', [
            'pProfessionnel' => $professionnel,
        ]);

    }

    public function consulterProfessionnel(ManagerRegistry $doctrine, int $id)
    {

        $professionnel = $doctrine->getRepository(Professionnel::class)->find($id);

        if (!$professionnel) {
            throw $this->createNotFoundException(
                'Aucun professionnel trouvé avec le numéro ' . $id
            );
        }

        return $this->render('professionnel/consulter.html.twig', ['professionnel' => $professionnel,]);
    }

    public function ajoutProfessionnel(ManagerRegistry $doctrine, Request $request){

        $professionnel = new professionnel();
        $form = $this->createForm(ProfessionnelAjouterType::class, $professionnel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $professionnel = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($professionnel);
            $entityManager->flush();

            return $this->render('professionnel/consulter.html.twig', ['professionnel' => $professionnel]);
        } else {
            return $this->render('professionnel/ajouter.html.twig', array('form' => $form->createView(),));
        }
    }

    public function modifierProfessionnel(ManagerRegistry $doctrine, $id, Request $request){

        $professionnel = $doctrine->getRepository(Professionnel::class)->find($id);

        $repository = $doctrine->getRepository(Professionnel::class);
        $professionnels = $repository->findAll();

        if (!$professionnel) {
           throw $this->createNotFoundException('Aucun professionnel trouvé avec le numéro '.$id);
        }
        else
        {
            $form = $this->createForm(ProfessionnelModifierType::class, $professionnel);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $professionnel = $form->getData();

                $entityManager = $doctrine->getManager();
                $entityManager->persist($professionnel);
                $entityManager->flush();

                return $this->render('professionnel/consulter.html.twig', ['professionnel' => $professionnel, 'pProfessionnel' => $professionnels]);
            }
            else{
                return $this->render('professionnel/modifier.html.twig', array('form' => $form->createView(), 'instrument' => $professionnel,));
            }
        }
    }
}