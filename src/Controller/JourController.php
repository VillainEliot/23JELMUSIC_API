<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Entity\Jours;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class JourController extends AbstractController
{
    public function listerJours(ManagerRegistry $doctrine, SerializerInterface $serializer): JsonResponse
    {
        $jours = $doctrine->getRepository(Jours::class)->findAll();

        $serializerController = new Serializer($serializer);
        $ignAttr = ['cours', 'jour'];
        return $serializerController->serializeObject($jours, $ignAttr);
    }
}
