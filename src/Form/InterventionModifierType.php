<?php

namespace App\Form;

use App\Entity\Intervention;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

class InterventionModifierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateDebut',DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => ['class' => 'mb-4 form-control'],

            ])
            ->add('dateFin',DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'required' => false,
                'attr' => ['class' => 'mb-4 form-control'],
            ])
            ->add('Professionnel', EntityType::class,[
                'class' => 'App\Entity\Professionnel',
                'choice_label' => 'nom',
                'attr' => ['class' => 'mb-4 form-control'],
            ])

            ->add('Descriptif', TextType::class, [
                'constraints' => [
                    new Length([
                        'min' => 10,
                        'max' => 100,
                        'minMessage' => 'La description doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'La description ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                    new Regex([
                        'pattern' => '/^[A-Za-zÀ-ÖØ-öø-ÿ0-9\s]+$/u',
                        'message' => 'Seules les lettres, les chiffres et les espaces sont autorisés.',
                    ]),

                ],
                'attr' => ['class' => 'mb-4 form-control'],
                'required' => false,
            ])

            ->add('Prix', NumberType::class, [
                'constraints' => [
                    new GreaterThanOrEqual([
                        'value' => 0,
                        'message' => 'Le prix ne peut pas être négatif.',
                    ]),
                ],
                'attr' => ['class' => 'mb-4 form-control'],
                'required' => false,
            ])


            ->add('enregistrer', SubmitType::class, [

                'label' => 'Modifier le prêt',
                'attr' => ['class' => 'btn btn-primary m-1']

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Intervention::class,
        ]);
    }
}
