<?php

namespace SMTC\MainBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityRepository;
use SMTC\MainBundle\Form\Model\User;
use SMTC\MainBundle\Entity\Country;

class AddProvinceFieldSubscriber implements EventSubscriberInterface
{
    private $factory;

    public function __construct(FormFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_BIND     => 'preBind'
        );
    }

    private function addProvinceForm($form, $province, $country)
    {
        $form->add($this->factory->createNamed('province','entity', $province, array(
            'class'         => 'MainBundle:Province',
            'empty_value'   => 'Provincia',
            'mapped'        => false,
            'query_builder' => function (EntityRepository $repository) use ($country) {
                $qb = $repository->createQueryBuilder('province')
                    ->innerJoin('province.country', 'country');
                if($country instanceof Country){
                    $qb->where('province.country = :country')
                    ->setParameter('country', $country);
                }elseif(is_numeric($country)){
                    $qb->where('country.id = :country')
                    ->setParameter('country', $country);
                }else{
                    $qb->where('country.name = :country')
                    ->setParameter('country', null);
                }

                return $qb;
            }
        )));
    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $province = ($data->city) ? $data->city->getProvince() : null ;
        $country = ($province) ? $province->getCountry() : null ;
        $this->addProvinceForm($form, $province, $country);
    }

    public function preBind(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        if(array_key_exists('country', $data)) {
            $province = $data['province'];
            $country = array_key_exists('country', $data) ? $data['country'] : null;
            $this->addProvinceForm($form, $province, $country);
        }
    }
}