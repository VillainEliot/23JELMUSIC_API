<?php

namespace App\Controller;

use App\Form\EleveModifierType;
use App\Form\EleveType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Proxies\__CG__\App\Entity\Eleve;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class EleveController extends AbstractController
{
    /*#[Route('/eleve', name: 'app_eleve')]*/
    public function index(): Response
    {
        return $this->render('eleve/index.html.twig', [
            'controller_name' => 'EleveController',
        ]);
    }

    public function listerEleve(ManagerRegistry $doctrine, SerializerInterface $serializer){

        $repository = $doctrine->getRepository(Eleve::class);

        $eleves= $repository->findAll();

        $serializerController = new Serializer($serializer);
        $ignAttr = ['eleves', 'eleve', 'cours','instruments', 'interventions', 'typeInstruments', 'interPrets', 'user'];
        return $serializerController->serializeObject($eleves, $ignAttr);

//        return $this->render('eleve/lister.html.twig', [
//            'pEleve' => $eleves,]);

    }

    public function consulterEleve(ManagerRegistry $doctrine, int $id, SerializerInterface $serializer){

        $eleve= $doctrine->getRepository(Eleve::class)->find($id);

        if (!$eleve) {
            return new JsonResponse(['error'=> true, 'message'=> 'L\'élève ne peut pas être consulté puisqu\'il n\'existe pas.']);
        }

        $serializerController = new Serializer($serializer);
        $ignAttr = ['eleves', 'eleve', 'cours','instruments', 'interventions', 'typeInstruments', 'interPrets', 'user'];
        return $serializerController->serializeObject($eleve, $ignAttr);
        //return new Response('Eleve : '.$eleve->getNom());
//        return $this->render('eleve/consulter.html.twig', [
//            'eleve' => $eleve,]);
    }

    public function ajouterEleve(Request $request, ManagerRegistry $doctrine, SerializerInterface $serializer): Response
    {
        // récupération des données
        $donnees = [
            'nom'=> $request->get('nom'),
            'prenom'=> $request->get('prenom'),
            'num_rue'=> $request->get('num_rue'),
            'rue'=> $request->get('rue'),
            'copos'=> $request->get('copos'),
            'ville'=> $request->get('ville'),
            'tel'=> $request->get('tel'),
            'mail'=> $request->get('mail'),
        ];
        //Création de l'objet
        $eleve = new Eleve();

        // Set les données
        $eleve->setNom($donnees['nom']);
        $eleve->setPrenom($donnees['prenom']);
        $eleve->setNumRue($donnees['num_rue']);
        $eleve->setRue($donnees['rue']);
        $eleve->setCopos($donnees['copos']);
        $eleve->setVille($donnees['ville']);
        $eleve->setTel($donnees['tel']);
        $eleve->setMail($donnees['mail']);

        // insertion en base
        $entityManager = $doctrine->getManager();
        $entityManager->persist($eleve);
        $entityManager->flush();

        $serializerController = new Serializer($serializer);
        $ignAttr = ['eleves', 'eleve', 'cours','instruments', 'interventions', 'typeInstruments', 'interPrets', 'user'];
        return $serializerController->serializeObject($eleve, $ignAttr);
//        return $this->render('eleve/ajouter.html.twig', [
//            'form' => $form->createView(),
//        ]);
    }

    public function modifierEleve(ManagerRegistry $doctrine, $id, Request $request, SerializerInterface $serializer){

        $eleve = $doctrine->getRepository(Eleve::class)->find($id);

        if (!$eleve) {
            return new JsonResponse(['error'=> true, 'message'=> 'L\'élève ne peut pas être modifié puisqu\'il n\'existe pas.']);
        }
        else
        {
            // récupération des données
            $donnees = [
                'nom'=> $request->get('nom'),
                'prenom'=> $request->get('prenom'),
                'num_rue'=> $request->get('num_rue'),
                'rue'=> $request->get('rue'),
                'copos'=> $request->get('copos'),
                'ville'=> $request->get('ville'),
                'tel'=> $request->get('tel'),
                'mail'=> $request->get('mail'),
            ];

            // Set les données
            $eleve->setNom($donnees['nom']);
            $eleve->setPrenom($donnees['prenom']);
            $eleve->setNumRue($donnees['num_rue']);
            $eleve->setRue($donnees['rue']);
            $eleve->setCopos($donnees['copos']);
            $eleve->setVille($donnees['ville']);
            $eleve->setTel($donnees['tel']);
            $eleve->setMail($donnees['mail']);

            // insertion en base
            $entityManager = $doctrine->getManager();
            $entityManager->persist($eleve);
            $entityManager->flush();

            $serializerController = new Serializer($serializer);
            $ignAttr = ['eleves', 'eleve', 'cours','instruments', 'interventions', 'typeInstruments', 'interPrets', 'user'];
            return $serializerController->serializeObject($eleve, $ignAttr);
        }
    }

    public function supprimerEleve(ManagerRegistry $doctrine, $id): JsonResponse
    {

        $repository = $doctrine->getRepository(Eleve::class);
        $eleve = $repository->find($id);

        if (!$eleve) {
            return new JsonResponse(['error'=> true, 'message'=> 'L\'élève ne peut pas être supprimé puisqu\'il n\'existe pas.']);
        }else {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($eleve);
            $entityManager->flush();
            return new JsonResponse(['error'=> false, 'message'=> 'Élève bien supprimé.']);
        }

    }

}
