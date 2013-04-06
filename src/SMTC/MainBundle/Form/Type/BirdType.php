<?php

namespace SMTC\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BirdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('animal', new AnimalType(), array(
                'data_class' => 'SMTC\MainBundle\Model\Bird',
            ))
            ->add('canFly', 'checkbox', array(
                'label' => 'Vuela?',
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SMTC\MainBundle\Model\Bird',
        ));
    }

    public function getName()
    {
        return 'bird';
    }
}
