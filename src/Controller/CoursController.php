<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Entity\Jours;
use App\Entity\Marque;
use App\Entity\Professeur;
use App\Entity\TypeCours;
use App\Entity\TypeInstrument;
use App\Form\CoursModifierType;
use App\Form\CoursType;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    public function ajouterCours(ManagerRegistry $doctrine, Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        // récupération des données
        $donnees = [
            'age_mini'=> $request->get('age_mini'),
            'heure_debut'=> $request->get('heure_debut'),
            'heure_fin'=> $request->get('heure_fin'),
            'nb_places'=> $request->get('nb_places'),
            'age_maxi'=> $request->get('age_maxi'),
            'typeCours'=> $request->get('typeCours'),
            'jours'=> $request->get('jours'),
            'professeur'=> $request->get('professeur'),
            'typeInstruments'=> $request->get('typeInstruments'),
        ];

        // Création et set les données
        $cours = new Cours();
        $cours->setAgeMini($donnees['age_mini']);

        $heure_debut = new DateTimeImmutable($donnees['heure_debut']);
        $cours->setHeureDebut($heure_debut);

        $heure_fin = new DateTimeImmutable($donnees['heure_fin']);
        $cours->setHeureFin($heure_fin);

        $cours->setNbPlaces($donnees['nb_places']);
        $cours->setAgeMaxi($donnees['age_maxi']);

        $repository = $doctrine->getRepository(TypeCours::class);
        $typeCours = $repository->find($donnees['typeCours']);
        $cours->setTypeCours($typeCours);

        $repository = $doctrine->getRepository(Jours::class);
        $jours = $repository->find($donnees['jours']);
        $cours->setJours($jours);

        $repository = $doctrine->getRepository(Professeur::class);
        $professeur = $repository->find($donnees['professeur']);
        $cours->setProfesseur($professeur);

        $repository = $doctrine->getRepository(TypeInstrument::class);
        $typeInstruments = $repository->find($donnees['typeInstruments']);
        $cours->setTypeInstruments($typeInstruments);

        $entityManager->persist($cours);
        $entityManager->flush();

        $serializerController = new Serializer($serializer);
        $ignAttr = ['cours', 'instrument', 'instruments', 'contratprets', 'eleves'];
        return $serializerController->serializeObject($cours, $ignAttr);
    }

    public function modifierCours(ManagerRegistry $doctrine, $id, Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer){

        $cours = $doctrine->getRepository(Cours::class)->find($id);

        //$repository = $doctrine->getRepository(Cours::class);
        //$cours = $repository->findAll();

        if (!$cours) {
            throw $this->createNotFoundException('Aucun cours trouvé avec le numéro '.$id);
        }else{
            // récupération des données
            $donnees = [
                'age_mini'=> $request->get('age_mini'),
                'heure_debut'=> $request->get('heure_debut'),
                'heure_fin'=> $request->get('heure_fin'),
                'nb_places'=> $request->get('nb_places'),
                'age_maxi'=> $request->get('age_maxi'),
                'typeCours'=> $request->get('typeCours'),
                'jours'=> $request->get('jours'),
                'professeur'=> $request->get('professeur'),
                'typeInstruments'=> $request->get('typeInstruments'),
            ];

            // Création et set les données
            $cours->setAgeMini($donnees['age_mini']);

            $heure_debut = new DateTimeImmutable($donnees['heure_debut']);
            $cours->setHeureDebut($heure_debut);

            $heure_fin = new DateTimeImmutable($donnees['heure_fin']);
            $cours->setHeureFin($heure_fin);

            $cours->setNbPlaces($donnees['nb_places']);
            $cours->setAgeMaxi($donnees['age_maxi']);

            $repository = $doctrine->getRepository(TypeCours::class);
            $typeCours = $repository->find($donnees['typeCours']);
            $cours->setTypeCours($typeCours);

            $repository = $doctrine->getRepository(Jours::class);
            $jours = $repository->find($donnees['jours']);
            $cours->setJours($jours);

            $repository = $doctrine->getRepository(Professeur::class);
            $professeur = $repository->find($donnees['professeur']);
            $cours->setProfesseur($professeur);

            $repository = $doctrine->getRepository(TypeInstrument::class);
            $typeInstruments = $repository->find($donnees['typeInstruments']);
            $cours->setTypeInstruments($typeInstruments);

            $entityManager->persist($cours);
            $entityManager->flush();

            $serializerController = new Serializer($serializer);
            $ignAttr = ['cours', 'instrument', 'instruments', 'contratprets', 'eleves'];
            return $serializerController->serializeObject($cours, $ignAttr);
        }
    }
    public function supprimerCours(ManagerRegistry $doctrine, $id): JsonResponse
    {

        $repository = $doctrine->getRepository(Cours::class);
        $cours = $repository->find($id);

        if (!$cours) {
            return new JsonResponse(['error'=> true, 'message'=> 'Le cours ne peut pas être supprimé puisqu\'il n\'existe pas.']);
        }else {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($cours);
            $entityManager->flush();
            return new JsonResponse(['error'=> false, 'message'=> 'Le cours à bien supprimé.']);
        }

    }
}