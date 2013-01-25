<?php

namespace SMTC\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use SMTC\MainBundle\Model\Location;
use SMTC\MainBundle\Form\Type\LocationType;
use SMTC\MainBundle\Entity\City;
use SMTC\MainBundle\Form\Type\PasswordType;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * @Route("/ejemplo")
 */
class ExampleController extends Controller
{
    /**
     * @Route("/", name="examples")
     * @Template()
     */
    public function examplesAction()
    {
        return array();
    }

    /**
     * @Route("/respuesta", name="examples_responses")
     * @Template()
     */
    public function responsesAction()
    {
        return array();
    }

    /**
     * @Route("/impersonating", name="examples_impersonating")
     * @Template()
     */
    public function impersonatingAction()
    {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $this->loginByUsername('smtc');
        }

        return array();
    }

    private function loginByUsername($username)
    {
        $inMemoryProvider = $this->get('smtc.main.security.provider.in_memory');
        $user = $inMemoryProvider->loadUserByUsername($username);
        $firewallName = 'secured_area';
        $token = new UsernamePasswordToken($user, $user->getPassword(), $firewallName, $user->getRoles());
        $this->container->get('security.context')->setToken($token);
    }

    /**
     * @Route("/userpassword", name="examples_userpassword")
     * @Template()
     */
    public function userPasswordAction()
    {
        $this->loginByUsername('smtc');

        $user = $this->get('security.context')->getToken()->getUser();
        $form = $this->createForm(new PasswordType(), $user);

        $request = $this->getRequest();

        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {

                // do amazing things

                $flashBag = $this->get('session')->getFlashBag();
                $flashBag->add('smtc_success', 'El password es correcto');

                return $this->redirect($this->generateUrl('examples_userpassword'));
            }
        }

        return array(
            'form' => $form->createView()
        );
    }

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
    public function newLocationAction()
    {
        $location = new Location();
        $form = $this->createForm(new LocationType(), $location);

        $request = $this->getRequest();

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
