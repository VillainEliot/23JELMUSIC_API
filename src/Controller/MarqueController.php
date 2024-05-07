<?php

namespace App\Controller;


use App\Entity\Marque;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class MarqueController extends AbstractController
{
    public function listerMarques(ManagerRegistry $doctrine, SerializerInterface $serializer): JsonResponse
    {
        $repository = $doctrine->getRepository(Marque::class);

        $marques = $repository->findAll();

        $serializerController = new Serializer($serializer);
        $ignAttr = ['instrument', 'instruments'];
        return $serializerController->serializeObject($marques, $ignAttr);
    }
}
