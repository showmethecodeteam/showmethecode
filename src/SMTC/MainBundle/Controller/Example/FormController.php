<?php

namespace SMTC\MainBundle\Controller\Example;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use SMTC\MainBundle\Entity\User;
use SMTC\MainBundle\Entity\Profile;
use SMTC\MainBundle\Entity\Address;
use SMTC\MainBundle\Form\Type\UserProfileType;
use SMTC\MainBundle\Form\Type\UserAddressesType;
use SMTC\MainBundle\Form\Type\UserType;

class FormController extends Controller
{
    /**
     * @Route("/forms", name="examples_forms")
     * @Template()
     */
    public function formsAction(Request $request)
    {
        $users = $this->getDoctrine()->getManager()->getRepository("MainBundle:User")->findAll();

        return array('users' => $users);
    }

    /**
     * @Route("/forms/one_to_one/new", name="examples_forms_one_to_one_create")
     * @Template("MainBundle:Example\Form:new_one_to_one.html.twig")
     */
    public function oneToOneNewAction(Request $request)
    {
        $user = new User();
        $profile = new Profile();
        $user->setProfile($profile);

        $form = $this->createForm(new UserProfileType(), $user);

        if ($request->isMethod("POST")) {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $em->persist($user);
                // $em->flush();

                $flashBag = $this->get('session')->getFlashBag();
                $flashBag->add('smtc_success', 'Se ha creado un usuario:');
                $flashBag->add('smtc_success', sprintf('Username: %s', $user->getUsername()));
                $flashBag->add('smtc_success', sprintf('Nombre: %s', $user->getProfile()->getName()));

                return $this->redirect($this->generateUrl('examples_forms'));
            }
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/forms/one_to_one/{username}/edit", name="examples_forms_one_to_one_edit")
     * @ParamConverter("user", class="MainBundle:User")
     * @Template("MainBundle:Example\Form:edit_one_to_one.html.twig")
     */
    public function oneToOneEditAction(User $user, Request $request)
    {
        $form = $this->createForm(new UserProfileType(), $user);

        if ($request->isMethod("POST")) {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $em->persist($user);
                // $em->flush();

                $flashBag = $this->get('session')->getFlashBag();
                $flashBag->add('smtc_success', 'Se ha creado un usuario:');
                $flashBag->add('smtc_success', sprintf('Username: %s', $user->getUsername()));
                $flashBag->add('smtc_success', sprintf('Nombre: %s', $user->getProfile()->getName()));

                return $this->redirect($this->generateUrl('examples_forms'));
            }
        }

        return array(
            'form' => $form->createView(),
            'user' => $user,
        );
    }

    /**
     * @Route("/forms/one_to_many/new", name="examples_forms_one_to_many_create")
     * @Template("MainBundle:Example\Form:new_one_to_many.html.twig")
     */
    public function oneToManyNewAction(Request $request)
    {
        $user = new User();

        $form = $this->createForm(new UserAddressesType(), $user);

        if ($request->isMethod("POST")) {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $em->persist($user);
                // $em->flush();

                $flashBag = $this->get('session')->getFlashBag();
                $flashBag->add('smtc_success', 'Se ha creado un usuario:');
                $flashBag->add('smtc_success', sprintf('Username: %s', $user->getUsername()));
                if (0 !== count($user->getAddresses())) {
                    $flashBag->add('smtc_success', 'Direcciones:');
                    foreach ($user->getAddresses() as $address) {
                        $flashBag->add('smtc_success', sprintf('&nbsp;&nbsp;%s (%s)', $address->getStreet(), $address->getCity()->getName()));
                    }
                }

                return $this->redirect($this->generateUrl('examples_forms'));
            }
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/forms/one_to_many/{username}/edit", name="examples_forms_one_to_many_edit")
     * @ParamConverter("user", class="MainBundle:User")
     * @Template("MainBundle:Example\Form:edit_one_to_many.html.twig")
     */
    public function oneToManyEditAction(User $user, Request $request)
    {
        $form = $this->createForm(new UserAddressesType(), $user);

        if ($request->isMethod("POST")) {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $em->persist($user);
                // $em->flush();

                $flashBag = $this->get('session')->getFlashBag();
                $flashBag->add('smtc_success', 'Se ha editado un usuario:');
                $flashBag->add('smtc_success', sprintf('Username: %s', $user->getUsername()));
                if (0 !== count($user->getAddresses())) {
                    $flashBag->add('smtc_success', 'Direcciones:');
                    foreach ($user->getAddresses() as $address) {
                        $flashBag->add('smtc_success', sprintf('&nbsp;&nbsp;%s (%s)', $address->getStreet(), $address->getCity()->getName()));
                    }
                }

                return $this->redirect($this->generateUrl('examples_forms'));
            }
        }

        return array(
            'form' => $form->createView(),
            'user' => $user,
        );
    }

    /**
     * @Route("/forms/user/new", name="examples_forms_user_create")
     * @Template("MainBundle:Example\Form:new_user.html.twig")
     */
    public function userNewAction(Request $request)
    {
        $user = new User();
        $profile = new Profile();
        $user->setProfile($profile);

        $form = $this->createForm(new UserType(), $user);

        if ($request->isMethod("POST")) {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $em->persist($user);
                // $em->flush();

                $flashBag = $this->get('session')->getFlashBag();
                $flashBag->add('smtc_success', 'Se ha creado un usuario:');
                $flashBag->add('smtc_success', sprintf('Username: %s', $user->getUsername()));
                $flashBag->add('smtc_success', sprintf('Nombre: %s', $user->getProfile()->getName()));
                if (0 !== count($user->getAddresses())) {
                    $flashBag->add('smtc_success', 'Direcciones:');
                    foreach ($user->getAddresses() as $address) {
                        $flashBag->add('smtc_success', sprintf('&nbsp;&nbsp;%s (%s)', $address->getStreet(), $address->getCity()->getName()));
                    }
                }

                return $this->redirect($this->generateUrl('examples_forms'));
            }
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/forms/user/{username}/edit", name="examples_forms_user_edit")
     * @ParamConverter("user", class="MainBundle:User")
     * @Template("MainBundle:Example\Form:edit_user.html.twig")
     */
    public function userEditAction(User $user, Request $request)
    {
        $form = $this->createForm(new UserType(), $user);

        if ($request->isMethod("POST")) {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $em->persist($user);
                // $em->flush();

                $flashBag = $this->get('session')->getFlashBag();
                $flashBag->add('smtc_success', 'Se ha editado un usuario:');
                $flashBag->add('smtc_success', sprintf('Username: %s', $user->getUsername()));
                $flashBag->add('smtc_success', sprintf('Nombre: %s', $user->getProfile()->getName()));
                if (0 !== count($user->getAddresses())) {
                    $flashBag->add('smtc_success', 'Direcciones:');
                    foreach ($user->getAddresses() as $address) {
                        $flashBag->add('smtc_success', sprintf('&nbsp;&nbsp;%s (%s)', $address->getStreet(), $address->getCity()->getName()));
                    }
                }

                return $this->redirect($this->generateUrl('examples_forms'));
            }
        }

        return array(
            'form' => $form->createView(),
            'user' => $user,
        );
    }
}
