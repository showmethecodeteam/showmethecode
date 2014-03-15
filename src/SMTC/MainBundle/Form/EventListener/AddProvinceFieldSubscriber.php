<?php

namespace SMTC\MainBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Doctrine\ORM\EntityRepository;
use SMTC\MainBundle\Entity\Country;

class AddProvinceFieldSubscriber implements EventSubscriberInterface
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

    private function addProvinceForm($form, $country_id, $province = null)
    {
        $formOptions = array(
            'class'         => 'MainBundle:Province',
            'empty_value'   => 'Provincia',
            'label'         => 'Provincia',
            'mapped'        => false,
            'attr'          => array(
                'class' => 'province_selector',
            ),
            'query_builder' => function (EntityRepository $repository) use ($country_id) {
                $qb = $repository->createQueryBuilder('province')
                    ->innerJoin('province.country', 'country')
                    ->where('country.id = :country')
                    ->setParameter('country', $country_id)
                ;

                return $qb;
            }
        );

        if ($province) {
            $formOptions['data'] = $province;
        }

        $form->add('province','entity', $formOptions);
    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $accessor = PropertyAccess::getPropertyAccessor();

        $city        = $accessor->getValue($data, $this->propertyPathToCity);
        $province    = ($city) ? $city->getProvince() : null;
        $country_id  = ($province) ? $province->getCountry()->getId() : null;

        $this->addProvinceForm($form, $country_id, $province);
    }

    public function preSubmit(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        $country_id = array_key_exists('country', $data) ? $data['country'] : null;

        $this->addProvinceForm($form, $country_id);
    }
}
