<?php

namespace SMTC\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('animal', new AnimalType(), array(
                'data_class' => 'SMTC\MainBundle\Model\Dog',
            ))
            ->add('breed', null, array(
                'label' => 'Raza'
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SMTC\MainBundle\Model\Dog',
        ));
    }

    public function getName()
    {
        return 'dog';
    }
}
