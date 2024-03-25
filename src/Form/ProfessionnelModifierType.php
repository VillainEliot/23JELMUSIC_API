<?php

namespace App\Form;

use App\Entity\Metier;
use App\Entity\Professionnel;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

class ProfessionnelModifierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => ['class' => 'mb-4 form-control'],
            ])
            ->add('numRue', NumberType::class, [
                'constraints' => [
                    new GreaterThanOrEqual([
                        'value' => 0,
                        'message' => 'Le prix ne peut pas être négatif.',
                    ]),
                ],
                'attr' => ['class' => 'mb-4 form-control'],
                'required' => false,
            ])

            ->add('rue', TextType::class, [
                'constraints' => [
                    new Length([
                        'min' => 1,
                        'max' => 50,
                        'minMessage' => 'La rue doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'La rue ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                    new Regex([
                        'pattern' => '/^[A-Za-zÀ-ÖØ-öø-ÿ0-9\s]+$/u',
                        'message' => 'Seules les lettres, les chiffres et les espaces sont autorisés.',
                    ]),

                ],
                'attr' => ['class' => 'mb-4 form-control'],
                'required' => false,
            ])
            ->add('copos', NumberType::class, [
                'constraints' => [
                    new GreaterThanOrEqual([
                        'value' => 0,
                        'message' => 'Le prix ne peut pas être négatif.',
                    ]),
                ],
                'attr' => ['class' => 'mb-4 form-control'],
                'required' => false,
            ])
            ->add('ville', TextType::class, [
                'constraints' => [
                    new Length([
                        'min' => 1,
                        'max' => 50,
                        'minMessage' => 'La rue doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'La rue ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                    new Regex([
                        'pattern' => '/^[A-Za-zÀ-ÖØ-öø-ÿ0-9\s]+$/u',
                        'message' => 'Seules les lettres, les chiffres et les espaces sont autorisés.',
                    ]),

                ],
                'attr' => ['class' => 'mb-4 form-control'],
                'required' => false,
            ])
            ->add('tel', TextType::class, [
                'constraints' => [
                    new Length([
                        'min' => 10,
                        'max' => 17,
                        'minMessage' => 'Il faut {{ limit }} chiffre.',
                        'maxMessage' => 'il faut pas plus de  {{ limit }} chiffre.',
                    ]),
                ],
                'attr' => ['class' => 'mb-4 form-control'],
                'required' => false,
            ])
            ->add('mail', TextType::class, [
                'attr' => ['class' => 'mb-4 form-control'],
                'required' => false,
            ])
            ->add('metier', EntityType::class, [
                'class' => Metier::class,
                'choice_label' => 'libelle',
                'attr' => ['class' => 'mb-4 form-control'],
                'multiple' => true,
                'expanded' => true,
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
            'data_class' => Professionnel::class,
        ]);
    }
}
