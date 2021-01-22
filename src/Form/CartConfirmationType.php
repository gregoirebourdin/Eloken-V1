<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CartConfirmationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('full_name', TextType::class,  [
                'label' => 'Nom complet',
                'required' => true,
                'attr' =>
                    [
                        'class' => 'form-input',
                        'placeholder' => "Entrez votre nom complet"
                    ]
        ])
            ->add('address', TextAreaType::class,  [
                'label' => 'Adresse complète',
                'required' => true,
                'attr' =>
                    [
                        'class' => 'form-input',
                        'placeholder' => "Entrez votre adresse complete"
                    ]
            ])
            ->add('postalCode', TextType::class,  [
                'label' => 'Adresse complète',
                'required' => true,
                'attr' =>
                    [
                        'class' => 'form-input',
                        'placeholder' => "Entrez votre code postal"
                    ]
            ])
            ->add('city', TextType::class,  [
                'label' => 'Ville',
                'required' => true,
                'attr' =>
                    [
                        'class' => 'form-input',
                        'placeholder' => "Entrez le nom de votre ville"
                    ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
