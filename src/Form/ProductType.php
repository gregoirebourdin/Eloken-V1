<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    // Form configuration
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,
                [
                    'label' => 'Nom du produit',
                    'required' => false,
                    'attr' =>
                        [
                            'class' => 'form-input',
                            'placeholder' => "Donnez un nom a votre produit"
                        ]
                ])
            ->add('shortDescription', TextareaType::class, [
                'label' => 'Déscription Courte',
                'required' => false,
                'attr' => [
                    'class' => 'form-input',
                    'placeholder' => "Ecrivez une brieve description"
                ]
            ])
            ->add('price', MoneyType::class,
                [
                    'label' => 'Prix',
                    'required' => false,
                    'attr' => [
                        'class' => 'form-input',
                        'placeholder' => "Entrez un prix"
                    ],
                    'divisor' => 100
                ])
            ->add('category', EntityType::class,
                [
                    'label' => 'Catégorie',
                    'attr' => [
                        'class' => 'form-input'],
                    'placeholder' => "Choisissez une Catégorie",
                    'class' => Category::class,
                    'choice_label' => 'name'
                ])
            ->add('mainPicture', UrlType::class,
                [
                    'label' => "URL d'une image"
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        // This is the class we will be working with
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
