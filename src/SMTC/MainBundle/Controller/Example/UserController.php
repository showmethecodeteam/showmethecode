<?php

namespace SMTC\MainBundle\Controller\Example;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SMTC\MainBundle\Form\Type\PasswordType;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class UserController extends Controller
{
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
}
