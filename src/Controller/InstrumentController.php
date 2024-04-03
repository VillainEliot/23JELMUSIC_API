<?php

namespace App\Controller;

use App\Entity\Instrument;
use App\Entity\Marque;
use App\Entity\TypeInstrument;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;


class InstrumentController extends AbstractController
{
//    #[Route('/instrument', name: 'app_instrument')]
//    public function index(): Response
//    {
//        return $this->render('instrument/index.html.twig', [
//            'controller_name' => 'InstrumentController',
//        ]);
//    }

    public function consulterInstrument(ManagerRegistry $doctrine , int $id, SerializerInterface $serializer): JsonResponse
    {

        $instrument = $doctrine->getRepository(Instrument::class)->find($id);

        if(!$instrument){
            return new JsonResponse(['error'=> true, 'message'=> 'L\'instrument ne peut pas être consulté puisqu\'il n\'existe pas.']);
        }

        $serializerController = new Serializer($serializer);
        $ignAttr = ['instrument', 'instruments', 'cours', 'inscriptions', 'typeInstruments'];
        return $serializerController->serializeObject($instrument, $ignAttr);
//        return $this->render('instrument/consulter.html.twig', [
//            'instrument' => $instrument,
//            ]);
    }

    public function listerInstrument(ManagerRegistry $doctrine, SerializerInterface $serializer): JsonResponse
    {
        $repository = $doctrine->getRepository(Instrument::class);

        $instruments = $repository->findAll();

        $serializerController = new Serializer($serializer);
        $ignAttr = ['instrument', 'instruments', 'cours', 'inscriptions', 'typeInstruments'];
        return $serializerController->serializeObject($instruments, $ignAttr);

//        return $this->render('instrument/lister.html.twig', ['pInstruments' => $instruments,]);
    }

    public function ajouterInstrument(ManagerRegistry $doctrine, Request $request,SerializerInterface $serializer): JsonResponse
    {
        // récupération des données
        $donnees = [
            'nom'=> $request->get('nom'),
            'num_serie'=> $request->get('num_serie'),
            'date_achat'=> $request->get('date_achat'),
            'prix_achat'=> $request->get('prix_achat'),
            'marque_id'=> $request->get('marque_id'),
            'type_id'=> $request->get('type_id'),
            'utilisation'=> $request->get('utilisation'),
            'cheminImage'=> $request->get('cheminImage'),
        ];
        // Création et set les données
        $instrument = new Instrument();
        $instrument->setNom($donnees['nom']);
        $instrument->setNumSerie($donnees['num_serie']);
        $dateAchat = new DateTimeImmutable($donnees['date_achat']);
        $instrument->setDateAchat($dateAchat);
        $instrument->setPrixAchat($donnees['prix_achat']);

        $repository = $doctrine->getRepository(Marque::class);
        $marque = $repository->find($donnees['marque_id']);
        $instrument->setMarque($marque);

        $repository = $doctrine->getRepository(TypeInstrument::class);
        $type = $repository->find($donnees['type_id']);
        $instrument->setType($type);

        $instrument->setUtilisation($donnees['utilisation']);
        $instrument->setCheminImage($donnees['cheminImage']);

        // insertion en base
        $entityManager = $doctrine->getManager();
        $entityManager->persist($instrument);
        $entityManager->flush();

        $serializerController = new Serializer($serializer);
        $ignAttr = ['instrument', 'instruments', 'cours', 'inscriptions', 'typeInstruments'];
        return $serializerController->serializeObject($instrument, $ignAttr);
    }

    public function modifierInstrument(ManagerRegistry $doctrine, $id, Request $request, SerializerInterface $serializer): JsonResponse
    {

        $instrument = $doctrine->getRepository(Instrument::class)->find($id);

        if (!$instrument) {
            return new JsonResponse(['error'=> true, 'message'=> 'L\'instrument ne peut pas être modifié puisqu\'il n\'existe pas.']);
        }else{

            // récupération des données
            $donnees = [
                'nom'=> $request->get('nom'),
                'num_serie'=> $request->get('num_serie'),
                'date_achat'=> $request->get('date_achat'),
                'prix_achat'=> $request->get('prix_achat'),
                'marque_id'=> $request->get('marque_id'),
                'type_id'=> $request->get('type_id'),
                'utilisation'=> $request->get('utilisation'),
                'cheminImage'=> $request->get('cheminImage'),
            ];
            // Création et set les données
            $instrument->setNom($donnees['nom']);
            $instrument->setNumSerie($donnees['num_serie']);
            $dateAchat = new DateTimeImmutable($donnees['date_achat']);
            $instrument->setDateAchat($dateAchat);
            $instrument->setPrixAchat($donnees['prix_achat']);

            $repository = $doctrine->getRepository(Marque::class);
            $marque = $repository->find($donnees['marque_id']);
            $instrument->setMarque($marque);

            $repository = $doctrine->getRepository(TypeInstrument::class);
            $type = $repository->find($donnees['type_id']);
            $instrument->setType($type);

            $instrument->setUtilisation($donnees['utilisation']);
            $instrument->setCheminImage($donnees['cheminImage']);

            $entityManager = $doctrine->getManager();
            $entityManager->persist($instrument);
            $entityManager->flush();

            $serializerController = new Serializer($serializer);
            $ignAttr = ['instrument', 'instruments', 'cours', 'inscriptions'];
            return $serializerController->serializeObject($instrument, $ignAttr);
        }
    }

    public function supprimerInstrument(ManagerRegistry $doctrine, $id): JsonResponse
    {

        $repository = $doctrine->getRepository(Instrument::class);
        $instrument = $repository->find($id);

        if (!$instrument) {
            return new JsonResponse(['error'=> true, 'message'=> 'L\'instrument ne peut pas être supprimé puisqu\'il n\'existe pas.']);
        }else {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($instrument);
            $entityManager->flush();
            return new JsonResponse(['error'=> false, 'message'=> 'Instrument bien supprimé.']);
        }

    }

}
