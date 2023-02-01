<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('what', TextType::class, [
                'required'   => false,
                'attr' => [
                    'placeholder' => "Métier, secteur d'activité, ..."
                ]
            ])
            ->add('where', ChoiceType::class, [
                'choices' => [
                    'Bordeaux' => 'Bordeaux',
                    'Lille' => 'Lille',
                    'Lyon' => 'Lyon',
                    'Marseille' => 'Marseille',
                    'Paris' => 'Paris',
                    'Toulouse' => 'Toulouse',
                    'Nice' => 'Nice',
                    'Nantes' => 'Nantes',
                    'Montpellier' => 'Montpellier',
                    'Strasbourg' => 'Strasbourg'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Rechercher',
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
                ]
            ])
            ->setMethod('GET');

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
