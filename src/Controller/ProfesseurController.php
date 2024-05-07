<?php

namespace App\Controller;

use App\Entity\Professeur;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;


class ProfesseurController extends AbstractController
{
//    #[Route('/instrument', name: 'app_instrument')]
//    public function index(): Response
//    {
//        return $this->render('instrument/index.html.twig', [
//            'controller_name' => 'InstrumentController',
//        ]);
//    }

    public function consulterProfesseur(ManagerRegistry $doctrine , int $id, SerializerInterface $serializer): JsonResponse
    {

        $instrument = $doctrine->getRepository(Professeur::class)->find($id);

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

    public function listerProfesseur(ManagerRegistry $doctrine, SerializerInterface $serializer): JsonResponse
    {
        $repository = $doctrine->getRepository(Professeur::class);

        $instruments = $repository->findAll();

        $serializerController = new Serializer($serializer);
        $ignAttr = ['instrument', 'instruments', 'cours', 'inscriptions', 'typeInstruments'];
        return $serializerController->serializeObject($instruments, $ignAttr);

//        return $this->render('instrument/lister.html.twig', ['pInstruments' => $instruments,]);
    }

}
