<?php

namespace App\Controller;

use App\Entity\ContratPret;
use App\Entity\Cours;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AcceuilController extends AbstractController
{
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Cours::class);
        $cours = $repository->findAll();

        return $this->render('acceuil/index.html.twig', [
            'controller_name' => 'AcceuilController',
            'pCours' => $cours,
        ]);
    }
}
