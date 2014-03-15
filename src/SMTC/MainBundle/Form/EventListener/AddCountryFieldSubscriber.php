<?php

namespace SMTC\MainBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AddCountryFieldSubscriber implements EventSubscriberInterface
{
    private $propertyPathToCity;

    public function __construct($propertyPathToCity)
    {
        $this->propertyPathToCity = $propertyPathToCity;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT   => 'preSubmit'
        );
    }

    private function addCountryForm($form, $country = null)
    {
        $formOptions = array(
            'class'         => 'MainBundle:Country',
            'mapped'        => false,
            'label'         => 'País',
            'empty_value'   => 'País',
            'attr'          => array(
                'class' => 'country_selector',
            ),
        );

        if ($country) {
            $formOptions['data'] = $country;
        }

        $form->add('country', 'entity', $formOptions);
    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $accessor = PropertyAccess::getPropertyAccessor();

        $city    = $accessor->getValue($data, $this->propertyPathToCity);
        $country = ($city) ? $city->getProvince()->getCountry() : null;

        $this->addCountryForm($form, $country);
    }

    public function preSubmit(FormEvent $event)
    {
        $form = $event->getForm();

        $this->addCountryForm($form);
    }
}
