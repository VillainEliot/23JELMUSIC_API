<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Entity\Eleve;
use App\Entity\Inscription;
use App\Form\InscriptionModifierType;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class InscriptionController extends AbstractController
{
    /*#[Route('/inscription', name: 'app_inscription')]*/
    public function index(): Response
    {
        return $this->render('inscription/index.html.twig', [
            'controller_name' => 'InscriptionController',
        ]);
    }

    public function listerInscription(ManagerRegistry $doctrine, SerializerInterface $serializer){

        $repository = $doctrine->getRepository(Inscription::class);

        $inscriptions= $repository->findAll();
        $serializerController = new Serializer($serializer);
        $ignAttr = ['inscriptions', 'inscription', 'contratpret', 'contratprets', 'typeInstruments', 'typeCours'];
        return $serializerController->serializeObject($inscriptions, $ignAttr);


    }

    public function listerInscriptionByCours(ManagerRegistry $doctrine, SerializerInterface $serializer, int $id){

        $repository = $doctrine->getRepository(Inscription::class);

        $inscriptions= $repository->findBy(['cours' => $id]);
        $serializerController = new Serializer($serializer);
        $ignAttr = ['inscriptions', 'inscription', 'contratpret', 'contratprets', 'typeInstruments', 'typeCours'];
        return $serializerController->serializeObject($inscriptions, $ignAttr);


    }

    public function consulterInscription(ManagerRegistry $doctrine, SerializerInterface $serializer, int $id){

        $inscription = $doctrine->getRepository(Inscription::class)->find($id);

        if (!$inscription) {
            return new JsonResponse(['error'=> true, 'message'=> 'L\'inscription ne peut pas être consulté puisqu\'il n\'existe pas.']);
        }

        $serializerController = new Serializer($serializer);
        $ignAttr = ['inscriptions', 'inscription', 'contratpret', 'contratprets', 'typeInstruments', 'typeCours'];
        return $serializerController->serializeObject($inscription, $ignAttr);
    }

    public function ajouterInscription(Request $request, ManagerRegistry $doctrine, SerializerInterface $serializer): Response
    {
        $error = false;
        // récupération des données
        $donnees = [
            'coursIdToInscription'=> $request->get('coursIdToInscription'),
            'eleveIdToInscription'=> $request->get('eleveIdToInscription'),
        ];
        $eleve = $doctrine->getRepository(Eleve::class)->find($donnees['eleveIdToInscription']);
        $cours = $doctrine->getRepository(Cours::class)->find($donnees['coursIdToInscription']);
        if ($eleve == null or $cours == null){
            $error = true;
        }
        // Création et set les données
        $inscription = new Inscription();
        $inscription->setCours($cours);
        $inscription->setEleve($eleve);
        $inscription->setDateInscription(new \DateTime());

        if ($error){
            return new JsonResponse(['error'=> true, 'message'=> 'Le cours ou l\'élève n\'existe pas']);
        }else{
            // insertion en base
            $entityManager = $doctrine->getManager();
            $entityManager->persist($inscription);
            $entityManager->flush();

            $serializerController = new Serializer($serializer);
            $ignAttr = ['inscriptions', 'inscription', 'contratpret', 'contratprets', 'typeInstruments', 'typeCours'];
            return $serializerController->serializeObject($inscription, $ignAttr);
        }
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

    public function supprimerInscription(ManagerRegistry $doctrine, $id): JsonResponse
    {

        $repository = $doctrine->getRepository(Inscription::class);
        $inscription = $repository->find($id);

        if (!$inscription) {
            return new JsonResponse(['error'=> true, 'message'=> 'L\'inscription ne peut pas être supprimé puisqu\'il n\'existe pas.']);
        }else {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($inscription);
            $entityManager->flush();
            return new JsonResponse(['error'=> false, 'message'=> 'Inscription bien supprimé.']);
        }

    }
}
