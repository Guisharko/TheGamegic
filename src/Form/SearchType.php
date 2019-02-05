<?php

namespace App\Form;

use App\Entity\Oracle;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdvanceSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('card_type', ChoiceType::class, [
                'label' => false,
                'choices' => [
                    'Nom' => 'name',
                    'Type' => 'type_field',
                    'Couleur' => 'color'
                ],
                'attr' => [
                    'class' => 'form-control-lg search_options'
                ],
            ])
            ->add('search_type_field', EntityType::class, [
                'class' => Oracle::class,
                'choice_label' => 'text',
            ])
            ->add('search', TextType::class, [
                'label' => false,
                'empty_data' => '',
                'attr' => [
                    'class' => 'form-control-lg search_field',
                    'placeholder' => 'Rechercher un film, une série TV, un acteur...'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Recherche',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}