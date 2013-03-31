<?php

namespace SMTC\MainBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use SMTC\MainBundle\Entity\User;
use SMTC\MainBundle\Entity\Profile;
use SMTC\MainBundle\Entity\Address;
use Doctrine\Common\Collections\ArrayCollection;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $users = array(
            'pepe'   => array(
                'name' => 'Pepe',
                'addresses' => array(
                    array(
                        'street' => 'Calamar 23',
                        'city'   => 'valencia',
                    ),
                    array(
                        'street' => 'Perico 3',
                        'city'   => 'gandia',
                    ),
                ),
            ),
            'juan'   => array(
                'name' => 'Juan',
                'addresses' => array(
                    array(
                        'street' => 'Castellana 45',
                        'city'   => 'madrid',
                    ),
                ),
            ),
            'manuel' => array(
                'name' => 'Manuel',
                'addresses' => array(
                    array(
                        'street' => 'Principal 94',
                        'city'   => 'fafe',
                    ),
                ),
            ),
        );

        foreach ($users as $username => $user) {
            $newUser = new User();
            $newUser->setUsername($username);
            $profile = new Profile();
            $profile->setName($user['name']);
            $newUser->setProfile($profile);
            $addresses = new ArrayCollection();
            foreach ($user['addresses'] as $address) {
                $newAddress = new Address();
                $newAddress->setStreet($address['street']);
                $city = sprintf('city-%s', $address['city']);
                $newAddress->setCity($this->getReference($city));
                $addresses->add($newAddress);
            }

            $newUser->setAddresses($addresses);

            $manager->persist($newUser);
        }

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2;
    }
}
