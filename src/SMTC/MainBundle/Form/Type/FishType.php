<?php

namespace SMTC\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FishType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('animal', new AnimalType(), array(
                'data_class' => 'SMTC\MainBundle\Model\Fish',
            ))
            ->add('finsNumber', 'number', array(
                'label' => 'Numero de aletas',
                'help' => 'El número de aletas que tiene',
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SMTC\MainBundle\Model\Fish',
        ));
    }

    public function getName()
    {
        return 'fish';
    }
}
