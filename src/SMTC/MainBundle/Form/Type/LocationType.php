<?php

namespace SMTC\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use SMTC\MainBundle\Form\EventListener\AddCityFieldSubscriber;
use SMTC\MainBundle\Form\EventListener\AddProvinceFieldSubscriber;
use SMTC\MainBundle\Form\EventListener\AddCountryFieldSubscriber;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $subscriber = new AddCityFieldSubscriber($builder->getFormFactory());
        $builder->addEventSubscriber($subscriber);
        $subscriber = new AddProvinceFieldSubscriber($builder->getFormFactory());
        $builder->addEventSubscriber($subscriber);
        $subscriber = new AddCountryFieldSubscriber($builder->getFormFactory());
        $builder->addEventSubscriber($subscriber);

        $builder->add('address');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SMTC\MainBundle\Form\Model\Location'
        ));
    }

    public function getName()
    {
        return 'location';
    }
}
