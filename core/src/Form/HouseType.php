<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\House;
use App\Entity\Option;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HouseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('surface')
            ->add('rooms')
            ->add('bedrooms')
            ->add('floor')
            ->add('price')
            ->add('heat', ChoiceType::class, [
                'choices' => [
                    House::HEAT_ELECTRIC => House::HEAT_ELECTRIC,
                    House::HEAT_GAS      => House::HEAT_GAS
                ],
            ])
            ->add('options', EntityType::class, [
                'class'        => Option::class,
                'choice_label' => 'name',
                'multiple'     => true,
            ])
            ->add('city')
            ->add('address')
            ->add('zipCode');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => House::class,
        ]);
    }
}
