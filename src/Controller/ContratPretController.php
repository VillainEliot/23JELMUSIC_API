<?php

namespace App\Controller;
use App\Entity\Eleve;
use App\Entity\Instrument;
use App\Form\ContratPretType;
use App\Form\ContratPretModifierType;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\ContratPret;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class ContratPretController extends AbstractController
{
    //#[Route('/contrat/pret', name: 'app_contrat_pret')]
    public function index(): Response
    {
        return $this->render('contratPret/index.html.twig', [
            'controller_name' => 'ContratPretController',
        ]);
    }

    public function listerContratPret(ManagerRegistry $doctrine, SerializerInterface $serializer){

        $repository = $doctrine->getRepository(ContratPret::class);

        $contratPrets= $repository->findAll();

        $serializerController = new Serializer($serializer);
        $ignAttr = ['contratPrets', 'contratPret','cours', 'intervention' => 'instruments'];
        return $serializerController->serializeObject($contratPrets, $ignAttr);
//        return $this->render('contratPret/lister.html.twig', [
//            'pContratPret' => $contratPrets,]);

    }

    public function consulterContratPret(ManagerRegistry $doctrine, int $id, SerializerInterface $serializer){

        $contratPret= $doctrine->getRepository(ContratPret::class)->find($id);

        if (!$contratPret) {
            throw $this->createNotFoundException(
                'Aucun ContratPret trouvé avec le numéro '.$id
            );
        }

        $serializerController = new Serializer($serializer);
        $ignAttr = ['contratPrets', 'contratPret','cours', 'intervention' => 'instruments'];
        return $serializerController->serializeObject($contratPret, $ignAttr);

        //return new Response('ContratPret : '.$ContratPret->getNom());
//        return $this->render('contratPret/consulter.html.twig', [
//            'contratPret' => $contratPret,]);
    }

    public function ajouterContratPret(Request $request, PersistenceManagerRegistry $doctrine, SerializerInterface $serializer):Response{

        $donnees = [
            'dateDebut'=> $request->get('dateDebut'),
            'dateFin'=> $request->get('dateFin'),
            'attestationAssurance'=> $request->get('attestationAssurance'),
            'etatDetailleDebut'=> $request->get('etatDetailleDebut'),
            'etatDetailleRetour'=> $request->get('etatDetailleRetour'),
            'eleve'=> $request->get('eleve'),
            'instrument'=> $request->get('instrument'),
        ];
        $contratPret = new contratPret();
        $dateDebut = new DateTimeImmutable($donnees['dateDebut']);
        $contratPret->setDateDebut($dateDebut);
        $dateFin = new DateTimeImmutable($donnees['dateFin']);
        $contratPret->setDateFin($dateFin);
        $contratPret->setAttestationAssurance($donnees['attestationAssurance']);
        $contratPret->setEtatDetailleDebut($donnees['etatDetailleDebut']);
        $contratPret->setEtatDetailleRetour($donnees['etatDetailleRetour']);

        $repository = $doctrine->getRepository(Eleve::class);
        $type = $repository->find($donnees['eleve']);
        $contratPret->setEleve($type);

        $repository = $doctrine->getRepository(Instrument::class);
        $type = $repository->find($donnees['instrument']);
        $contratPret->setInstrument($type);

        // insertion en base
        $entityManager = $doctrine->getManager();
        $entityManager->persist($contratPret);
        $entityManager->flush();

        $serializerController = new Serializer($serializer);
        $ignAttr = ['contratPrets', 'contratPret','cours', 'intervention' => 'instruments'];
        return $serializerController->serializeObject($contratPret, $ignAttr);
    }

    public function modifierContratPret(ManagerRegistry $doctrine, $id, Request $request, SerializerInterface $serializer){

        $contratPret = $doctrine->getRepository(ContratPret::class)->find($id);

        if (!$contratPret) {
            return new JsonResponse(['error'=> true, 'message'=> 'Le contrat ne peut pas être modifié puisqu\'il n\'existe pas.']);
        }else{
            $donnees = [
                'dateDebut'=> $request->get('dateDebut'),
                'dateFin'=> $request->get('dateFin'),
                'attestationAssurance'=> $request->get('attestationAssurance'),
                'etatDetailleDebut'=> $request->get('etatDetailleDebut'),
                'etatDetailleRetour'=> $request->get('etatDetailleRetour'),
                'eleve'=> $request->get('eleve'),
                'instrument'=> $request->get('instrument'),
            ];
            $contratPret = new contratPret();
            $dateDebut = new DateTimeImmutable($donnees['dateDebut']);
            $contratPret->setDateDebut($dateDebut);
            $dateFin = new DateTimeImmutable($donnees['dateFin']);
            $contratPret->setDateFin($dateFin);
            $contratPret->setAttestationAssurance($donnees['attestationAssurance']);
            $contratPret->setEtatDetailleDebut($donnees['etatDetailleDebut']);
            $contratPret->setEtatDetailleRetour($donnees['etatDetailleRetour']);

            $repository = $doctrine->getRepository(Eleve::class);
            $type = $repository->find($donnees['eleve']);
            $contratPret->setEleve($type);

            $repository = $doctrine->getRepository(Instrument::class);
            $type = $repository->find($donnees['instrument']);
            $contratPret->setInstrument($type);

            // insertion en base
            $entityManager = $doctrine->getManager();
            $entityManager->persist($contratPret);
            $entityManager->flush();

            $serializerController = new Serializer($serializer);
            $ignAttr = ['contratPrets', 'contratPret','cours', 'intervention' => 'instruments'];
            return $serializerController->serializeObject($contratPret, $ignAttr);
        }
    }

    public function supprimerContratPret(ManagerRegistry $doctrine, $id): JsonResponse
    {

        $repository = $doctrine->getRepository(ContratPret::class);
        $contratPret = $repository->find($id);

        if (!$contratPret) {
            return new JsonResponse(['error'=> true, 'message'=> 'Le contrat ne peut pas être supprimé puisqu\'il n\'existe pas.']);
        }else {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($contratPret);
            $entityManager->flush();
            return new JsonResponse(['error'=> false, 'message'=> 'Le contrat à bien supprimé.']);
        }

    }


}
