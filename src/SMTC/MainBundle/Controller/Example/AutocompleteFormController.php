<?php

namespace SMTC\MainBundle\Controller\Example;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use SMTC\MainBundle\Form\Type\SelectCityType;
use SMTC\MainBundle\Entity\City;

class AutocompleteFormController extends Controller
{
    /**
     * @Route("/autocomplete-forms", name="examples_autocomplete_forms")
     * @Template()
     */
    public function autocompleteFormAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cities = $em->getRepository('MainBundle:City')->findAll();

        return array(
            'cities' => $cities,
        );
    }

    /**
     * @Route("/autocomplete-forms/get-cities", name="examples_autocomplete_get_cities")
     */
    public function getCitiesAction(Request $request)
    {
        $term = $request->query->get('term', null);

        $em = $this->getDoctrine()->getManager();

        $cities = $em->getRepository('MainBundle:City')->findByTerm($term);

        return new JsonResponse($cities);
    }

    /**
     * @Route("/autocomplete-forms/select-city", name="examples_autocomplete_forms_select_city")
     * @Template("MainBundle:Example\AutocompleteForm:select_city.html.twig")
     */
    public function selectCityAction(Request $request)
    {
        $form = $this->createForm(new SelectCityType());

        $form->handleRequest($request);

        if ($form->isValid()) {

            $city = $form->get('city')->getData();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('smtc_success', 'Se ha seleccionado la ciudad:');
            $flashBag->add('smtc_success', $city->getName());

            return $this->redirect($this->generateUrl('examples_autocomplete_forms_select_city_edit', array(
                'slug' => $city->getSlug(),
            )));
        }

        $em = $this->getDoctrine()->getManager();

        $cities = $em->getRepository('MainBundle:City')->findAll();

        return array(
            'form'   => $form->createView(),
            'cities' => $cities,
        );
    }

    /**
     * @Route("/autocomplete-forms/select-city/{slug}", name="examples_autocomplete_forms_select_city_edit")
     * @ParamConverter("city", class="MainBundle:City")
     * @Template("MainBundle:Example\AutocompleteForm:select_city.html.twig")
     */
    public function editCityAction(Request $request, City $city)
    {
        $form = $this->createForm(new SelectCityType(), array('city' => $city));

        $form->handleRequest($request);

        if ($form->isValid()) {

            $city = $form->get('city')->getData();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('smtc_success', 'Se ha seleccionado la ciudad:');
            $flashBag->add('smtc_success', $city->getName());

            return $this->redirect($this->generateUrl('examples_autocomplete_forms_select_city_edit', array(
                'slug' => $city->getSlug(),
            )));
        }

        $em = $this->getDoctrine()->getManager();

        $cities = $em->getRepository('MainBundle:City')->findAll();

        return array(
            'form'   => $form->createView(),
            'cities' => $cities,
        );
    }
}
