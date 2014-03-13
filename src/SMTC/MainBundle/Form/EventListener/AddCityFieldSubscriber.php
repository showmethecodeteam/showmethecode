<?php

namespace SMTC\MainBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Doctrine\ORM\EntityRepository;
use SMTC\MainBundle\Entity\Province;
use SMTC\MainBundle\Entity\City;

class AddCityFieldSubscriber implements EventSubscriberInterface
{
    private $propertyPathToCity;

    public function __construct($propertyPathToCity = 'city')
    {
        $this->propertyPathToCity = $propertyPathToCity;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::POST_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT    => 'preSubmit'
        );
    }

    private function addCityForm($form, $province_id)
    {
        $formOptions = array(
            'class'         => 'MainBundle:City',
            'empty_value'   => 'Ciudad',
            'label'         => 'Ciudad',
            'attr'          => array(
                'class' => 'city_selector',
            ),
            'query_builder' => function (EntityRepository $repository) use ($province_id) {
                $qb = $repository->createQueryBuilder('city')
                    ->innerJoin('city.province', 'province')
                    ->where('province.id = :province')
                    ->setParameter('province', $province_id)
                ;

                return $qb;
            }
        );

        $form->add($this->propertyPathToCity, 'entity', $formOptions);
    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $accessor    = PropertyAccess::createPropertyAccessor();

        $city        = $accessor->getValue($data, $this->propertyPathToCity);
        $province_id = ($city) ? $city->getProvince()->getId() : null;

        $this->addCityForm($form, $province_id);
    }

    public function preSubmit(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        $province_id = array_key_exists('province', $data) ? $data['province'] : null;

        $this->addCityForm($form, $province_id);
    }
}
