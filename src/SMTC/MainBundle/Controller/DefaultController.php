<?php

namespace SMTC\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/provinces", name="select_provinces")
     */
    public function provincesAction(Request $request)
    {
        $country_id = $request->request->get('country_id');

        $em = $this->getDoctrine()->getManager();

        $provinces = $em->getRepository('MainBundle:Province')->findByCountryId($country_id);

        return new JsonResponse($provinces);
    }

    /**
     * @Route("/cities", name="select_cities")
     */
    public function citiesAction(Request $request)
    {
        $province_id = $request->request->get('province_id');

        $em = $this->getDoctrine()->getManager();

        $cities = $em->getRepository('MainBundle:City')->findByProvinceId($province_id);

        return new JsonResponse($cities);
    }
}
