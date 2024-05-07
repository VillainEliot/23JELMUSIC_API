<?php

namespace App\Controller;

use App\Entity\TypeInstrument;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class TypeInstrumentController extends AbstractController
{
//    #[Route('/type/instrument', name: 'app_type_instrument')]
    public function listerInstruments(ManagerRegistry $doctrine, SerializerInterface $serializer): JsonResponse
    {
        $repository = $doctrine->getRepository(TypeInstrument::class);

        $instruments = $repository->findAll();

        $serializerController = new Serializer($serializer);
        $ignAttr = ['instrument', 'instruments', 'cours', 'professeur', 'typeInstruments'];
        return $serializerController->serializeObject($instruments, $ignAttr);
    }
}
