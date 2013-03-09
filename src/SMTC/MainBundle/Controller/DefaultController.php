<?php

namespace SMTC\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/provinces", name="select_provinces")
     * @Template()
     */
    public function provincesAction()
    {
        $country_id = $this->getRequest()->request->get('country_id');

        $em = $this->getDoctrine()->getManager();

        $provinces = $em->getRepository('MainBundle:Province')->findByCountryId($country_id);

        return array(
            'provinces' => $provinces
        );
    }

    /**
     * @Route("/cities", name="select_cities")
     * @Template()
     */
    public function citiesAction()
    {
        $province_id = $this->getRequest()->request->get('province_id');

        $em = $this->getDoctrine()->getManager();

        $cities = $em->getRepository('MainBundle:City')->findByProvinceId($province_id);

        return array(
            'cities' => $cities
        );
    }
}
