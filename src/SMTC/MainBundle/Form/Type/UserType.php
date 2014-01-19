<?php

namespace SMTC\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use SMTC\MainBundle\Entity\Address;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text', array(
                'label' => 'Nombre de usuario',
            ))
            ->add('profile', new ProfileType(), array(
                'label' => 'Perfil',
                'attr'  => array(
                    'class' => 'well'
                )
            ))
            ->add('addresses', 'collection', array(
                'type'           => new AddressType(),
                'label'          => 'Direcciones',
                'by_reference'   => false,
                'prototype_data' => new Address(),
                'allow_delete'   => true,
                'allow_add'      => true,
                'attr'           => array(
                    'class' => 'row addresses'
                )
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SMTC\MainBundle\Entity\User'
        ));
    }

    public function getName()
    {
        return 'user';
    }
}
