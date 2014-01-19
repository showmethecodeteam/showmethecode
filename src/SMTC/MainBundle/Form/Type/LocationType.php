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
        $factory = $builder->getFormFactory();
        $citySubscriber = new AddCityFieldSubscriber($factory);
        $builder->addEventSubscriber($citySubscriber);
        $provinceSubscriber = new AddProvinceFieldSubscriber($factory);
        $builder->addEventSubscriber($provinceSubscriber);
        $countrySubscriber = new AddCountryFieldSubscriber($factory);
        $builder->addEventSubscriber($countrySubscriber);

        $builder
            ->add('address', 'text', array(
                'label' => 'Calle'
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SMTC\MainBundle\Model\Location'
        ));
    }

    public function getName()
    {
        return 'location';
    }
}
