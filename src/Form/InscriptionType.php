<?php

namespace App\Form;

use App\Entity\Inscription;
use App\Entity\Eleve;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateInscription', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'mb-4 form-control'],
            ])
            ->add('cours', EntityType::class, [
                'class' => 'App\Entity\Cours',
                'attr' => ['class' => 'mb-4 form-control'],
                'choice_label' =>  function ($inscrit) {
                    return $inscrit->getId().'    '.$inscrit->getJours()->getLibelle(). '  '.$inscrit->getTypeCours()->getLibelle(). '  '.$inscrit->getTypeInstruments()->getLibelle();
                },
            ])
            ->add('eleve', EntityType::class, [
                'class' => 'App\Entity\Eleve',
                'choice_label' => function ($inscrit) {
                    return $inscrit->getNom() . ' ' . $inscrit->getPrenom();
                },
                'attr' => ['class' => 'mb-4 form-control'],
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder( 'e')
                        ->orderBy('e.nom', 'ASC');
                },
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Créer un éleve',
                'attr' => ['class' => 'btn btn-primary m-1'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Inscription::class,
        ]);
    }
}
