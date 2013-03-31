<?php

namespace SMTC\MainBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\Yaml\Yaml;
use SMTC\MainBundle\Entity\Country;
use SMTC\MainBundle\Entity\Province;
use SMTC\MainBundle\Entity\City;

class LoadCountryProvinceAndCityData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $fixturesPath = realpath(dirname(__FILE__). '/..');

        try {
            $countries = Yaml::parse(file_get_contents($fixturesPath . '/country_provinces_and_city.yml'));
        } catch (ParseException $e) {
            printf("Unable to parse the YAML string: %s", $e->getMessage());
        }

        foreach ($countries as $key => $country) {
            $newCountry = new Country();
            $newCountry->setName($country['name']);
            $newCountry->setSlug($country['slug']);

            $manager->persist($newCountry);

            foreach ($country['provinces'] as $key => $province) {
                $newProvince = new Province();
                $newProvince->setName($province['name']);
                $newProvince->setSlug($province['slug']);
                $newProvince->setCountry($newCountry);

                $manager->persist($newProvince);

                foreach ($province['cities'] as $key => $city) {
                    $newCity = new City();
                    $newCity->setName($city['name']);
                    $newCity->setSlug($city['slug']);
                    $newCity->setProvince($newProvince);

                    $manager->persist($newCity);

                    $this->addReference(sprintf('city-%s', $city['slug']), $newCity);
                }
            }
        }

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
}
