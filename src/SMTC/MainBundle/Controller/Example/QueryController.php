<?php

namespace SMTC\MainBundle\Controller\Example;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use SMTC\MainBundle\Entity\Country;

class QueryController extends Controller
{
    /**
     * @Route("/random-order", name="examples_query_random_order")
     * @Template()
     */
    public function randomOrderAction()
    {
        $em = $this->getDoctrine()->getManager();

        $countries = $em->getRepository("MainBundle:Country")->findAll();

        return array(
            'countries' => $countries
        );
    }

    /**
     * @Route("/random-order/{slug}", name="examples_query_random_order_country")
     * @ParamConverter("country", class="MainBundle:Country")
     * @Template()
     */
    public function randomOrderCitiesAction(Country $country)
    {
        $em = $this->getDoctrine()->getManager();

        $citiesToShow = 3;
        $cities = $em->getRepository("MainBundle:City")->findRandomCitiesByCountry($country, $citiesToShow);

        return array(
            'country' => $country,
            'cities'  => $cities
        );
    }

    /**
     * @Route("/subqueries", name="examples_query_subqueries")
     * @Template()
     */
    public function subqueriesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $countries = $em->getRepository("MainBundle:Country")->findAll();

        return array(
            'countries' => $countries
        );
    }

    /**
     * @Route("/exists/{slug}", name="examples_query_exists")
     * @ParamConverter("country", class="MainBundle:Country")
     * @Template()
     */
    public function existsAction(Country $country)
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository("MainBundle:User")->findUsersWithAddressesIn($country);

        return array(
            'users'    => $users,
            'subtitle' => sprintf("Usuarios con direcciones en %s", $country->getName()),
        );
    }

    /**
     * @Route("/not_exists/{slug}", name="examples_query_not_exists")
     * @ParamConverter("country", class="MainBundle:Country")
     * @Template("MainBundle:Example\Query:exists.html.twig")
     */
    public function notExistsAction(Country $country)
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository("MainBundle:User")->findUsersWithAllAddressesIn($country);

        return array(
            'users'    => $users,
            'subtitle' => sprintf("Usuarios con todas las direcciones en %s", $country->getName()),
        );
    }
}
