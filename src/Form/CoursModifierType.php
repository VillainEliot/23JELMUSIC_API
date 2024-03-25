<?php

namespace App\Form;

use App\Entity\Cours;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class CoursModifierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('typeInstruments', EntityType::class, [
                'class' => 'App\Entity\TypeInstrument',
                'choice_label' => 'libelle',
                'attr' => ['class' => 'mb-4 form-control'],
            ])
            ->add('jours', EntityType::class, [
                'class' => 'App\Entity\Jours',
                'choice_label' => 'libelle',
                'attr' => ['class' => 'mb-4 form-control'],
            ])
            ->add('HeureDebut', TimeType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'mb-4 form-control'],
            ])
            ->add('HeureFin', TimeType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'mb-4 form-control'],
            ])
            ->add('AgeMini', TextType::class,[
                'attr' => ['class' => 'mb-4 form-control'],
            ])
            ->add('AgeMaxi',TextType::class,[
                'attr' => ['class' => 'mb-4 form-control'],
            ])
            ->add('NbPlaces', IntegerType::class,[
                'attr' => ['class' => 'mb-4 form-control'],
            ])
            ->add('typeCours', EntityType::class, [
                'class' => 'App\Entity\TypeCours',
                'choice_label' => 'libelle',
                'attr' => ['class' => 'mb-4 form-control'],
            ])
            ->add('professeur', EntityType::class, [
                'class' => 'App\Entity\Professeur',
                'choice_label' => function ($professeur) {
                    return $professeur->getNom() . ' ' . $professeur->getPrenom();
                },
                'attr' => ['class' => 'mb-4 form-control'],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Modifier un cours',
                'attr' => ['class' => 'btn btn-primary m-1'],
            ]);
    }

    public function getParent(){
        return CoursType::class;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
        ]);
    }

    public function validateNbPlacesAndTypeCours($value, ExecutionContextInterface $context)
    {
        $NbPlaces = $context->getRoot()->get('NbPlaces')->getData();
        $typeCours = $value;

        // Check if typeCours is not null
        if ($typeCours !== null) {
            // If the number of places is 1, typeCours must be "Individuel"
            if ($NbPlaces === 1 && $typeCours->getLibelle() !== 'Cours Individuel') {
                $context->buildViolation('Si le nombre de place est de 1 le type de cours doit être Individuel.')
                    ->atPath('typeCours')
                    ->addViolation();
            }

            // If the number of places is greater than 1, typeCours must be "Collectif"
            if ($NbPlaces > 1 && $typeCours->getLibelle() !== 'Cours Collectif') {
                $context->buildViolation('Si le nombre de place est superieure à 1 le type de cours doit être Collectif.')
                    ->atPath('typeCours')
                    ->addViolation();
            }
        }
    }
}
