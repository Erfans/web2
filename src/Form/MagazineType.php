<?php

namespace App\Form;

use App\Entity\Magazine;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MagazineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('price')
            ->add('priceWithTax')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('issueNumber')
            ->add('bookStore')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Magazine::class,
        ]);
    }
}
