<?php

namespace SMTC\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array(
                'label' => 'Nombre'
            ))
            ->add('age', null, array(
                'label' => 'Edad'
            ))
            ->add('weight', null, array(
                'label' => 'Peso'
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'virtual' => true,
        ));
    }

    public function getName()
    {
        return 'animal';
    }
}
