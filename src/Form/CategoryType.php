<?php

namespace App\Form;

use App\Entity\Category;

use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    // Form configuration
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,
            [
                'label' => 'Nom de la categorie',
                'attr' =>
                    [
                        'class' => 'form-input',
                        'placeholder' => "Donnez un nom a votre Categorie"
                    ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        // This is the class we will be working with
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
