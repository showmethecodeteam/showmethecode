<?php

namespace SMTC\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use SMTC\MainBundle\Form\EventListener\AddCityFieldSubscriber;
use SMTC\MainBundle\Form\EventListener\AddProvinceFieldSubscriber;
use SMTC\MainBundle\Form\EventListener\AddCountryFieldSubscriber;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addEventSubscriber(new AddCountryFieldSubscriber())
            ->addEventSubscriber(new AddProvinceFieldSubscriber())
            ->addEventSubscriber(new AddCityFieldSubscriber())
        ;

        $builder
            ->add('street', 'text', array(
                'label' => 'Calle'
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SMTC\MainBundle\Entity\Address',
        ));
    }

    public function getName()
    {
        return 'address';
    }
}
