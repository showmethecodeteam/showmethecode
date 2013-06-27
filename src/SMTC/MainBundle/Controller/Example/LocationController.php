<?php

namespace SMTC\MainBundle\Controller\Example;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use SMTC\MainBundle\Model\Location;
use SMTC\MainBundle\Form\Type\LocationType;
use SMTC\MainBundle\Entity\City;

class LocationController extends Controller
{
    /**
     * @Route("/selects-dependientes", name="examples_dependent_selects")
     * @Template()
     */
    public function dependentSelectsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cities = $em->getRepository("MainBundle:City")->findAll();

        return array(
            'cities' => $cities
        );
    }

    /**
     * @Route("/selects-dependientes/location/new", name="examples_dependent_selects_location_new")
     * @Template("MainBundle:Example\Location:new_location.html.twig")
     */
    public function newLocationAction(Request $request)
    {
        $location = new Location();
        $form = $this->createForm(new LocationType(), $location);

        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {

                // do amazing things

                $flashBag = $this->get('session')->getFlashBag();
                $flashBag->add('smtc_success', 'Se ha creado una localización:');
                $flashBag->add('smtc_success', sprintf('Dirección: %s', $location->address));
                $flashBag->add('smtc_success', sprintf('Ciudad: %s', $location->city->getName()));

                return $this->redirect($this->generateUrl('examples_dependent_selects'));
            }
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/selects-dependientes/location/{slug}/edit", name="examples_dependent_selects_location_edit")
     * @ParamConverter("city", class="MainBundle:City")
     * @Template("MainBundle:Example\Location:edit_location.html.twig")
     */
    public function editLocationAction(City $city)
    {
        $location = new Location();
        $location->address = sprintf("Calle X número %d", rand(1,100));
        $location->city = $city;
        $form = $this->createForm(new LocationType(), $location);

        $request = $this->getRequest();

        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {

                // do amazing things

                $flashBag = $this->get('session')->getFlashBag();
                $flashBag->add('smtc_success', 'Se ha editado una localización:');
                $flashBag->add('smtc_success', sprintf('Dirección: %s', $location->address));
                $flashBag->add('smtc_success', sprintf('Ciudad: %s', $location->city->getName()));

                return $this->redirect($this->generateUrl('examples_dependent_selects'));
            }
        }

        return array(
            'form' => $form->createView(),
            'city' => $city
        );
    }
}
