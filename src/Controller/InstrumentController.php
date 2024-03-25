<?php

namespace App\Controller;

use App\Entity\Instrument;
use App\Form\InstrumentModifierType;
use App\Form\InstrumentAjouterType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;




class InstrumentController extends AbstractController
{
//    #[Route('/instrument', name: 'app_instrument')]
//    public function index(): Response
//    {
//        return $this->render('instrument/index.html.twig', [
//            'controller_name' => 'InstrumentController',
//        ]);
//    }

    public function consulterInstrument(ManagerRegistry $doctrine , int $id){

        $instrument = $doctrine->getRepository(Instrument::class)->find($id);

        if(!$instrument){
            throw $this->createNotFoundException('Aucun etudiant trouvé avec le numéro '.$id);
        }

        //return new Response('Etudiant : '.$etudiant->getNom());
        return $this->render('instrument/consulter.html.twig', [
            'instrument' => $instrument,
            ]);
    }

    public function listerInstrument(ManagerRegistry $doctrine){
        $repository = $doctrine->getRepository(Instrument::class);

        $instruments = $repository->findAll();
        return $this->render('instrument/lister.html.twig', ['pInstruments' => $instruments,]);
    }

    public function ajouterInstrument(ManagerRegistry $doctrine,Request $request){
        $instrument = new Instrument();
        $form = $this->createForm(InstrumentAjouterType::class, $instrument);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $instrument = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($instrument);
            $entityManager->flush();

            return $this->render('instrument/consulter.html.twig', ['instrument' => $instrument,]);
        } else {
            return $this->render('instrument/ajouter.html.twig', array('form' => $form->createView(),));
        }
    }

    public function modifierInstrument(ManagerRegistry $doctrine, $id, Request $request){

        $instrument = $doctrine->getRepository(Instrument::class)->find($id);

        $repository = $doctrine->getRepository(Instrument::class);
        $instruments = $repository->findAll();

        if (!$instrument) {
            throw $this->createNotFoundException('Aucun etudiant trouvé avec le numéro '.$id);
        }
        else
        {
            $form = $this->createForm(InstrumentModifierType::class, $instrument);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $instrument = $form->getData();
                $entityManager = $doctrine->getManager();
                $entityManager->persist($instrument);
                $entityManager->flush();
                return $this->render('instrument/consulter.html.twig', ['instrument' => $instrument, 'pInstruments' => $instruments]);
            }
            else{
                return $this->render('instrument/modifier.html.twig', array('form' => $form->createView(), 'instrument' => $instrument,));
            }
        }
    }

    public function supprimerInstrument(){

    }

}
