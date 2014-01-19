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
                'label' => 'Nombre',
            ))
            ->add('age', null, array(
                'label' => 'Edad',
                'help' => 'Días que tiene el animal',
            ))
            ->add('weight', null, array(
                'label' => 'Peso',
                'help' => 'Gramos de peso',
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'inherit_data' => true,
            'label'        => false,
        ));
    }

    public function getName()
    {
        return 'animal';
    }
}
