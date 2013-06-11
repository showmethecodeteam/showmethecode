<?php

namespace SMTC\MainBundle\Controller\Example;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use SMTC\MainBundle\Form\Type\DogType;
use SMTC\MainBundle\Form\Type\BirdType;
use SMTC\MainBundle\Form\Type\FishType;
use SMTC\MainBundle\Model\Dog;
use SMTC\MainBundle\Model\Bird;
use SMTC\MainBundle\Model\Fish;

class VirtualFormsController extends Controller
{
    /**
     * @Route("/forms/virtual", name="examples_virtual_forms")
     * @Template("MainBundle:Example\VirtualForms:virtual_forms.html.twig")
     */
    public function formsVirtualAction()
    {
        return array();
    }

    /**
     * @Route("/forms/virtual/dog/new", name="examples_virtual_forms_dog_create")
     * @Template("MainBundle:Example\VirtualForms:new_dog.html.twig")
     */
    public function dogNewAction(Request $request)
    {
        $dog = new Dog();

        $form = $this->createForm(new DogType(), $dog);

        if ($request->isMethod("POST")) {
            $form->bind($request);

            if ($form->isValid()) {

                $flashBag = $this->get('session')->getFlashBag();
                $flashBag->add('smtc_success', 'Se ha creado un perro:');
                $flashBag->add('smtc_success', sprintf('Nombre: %s', $dog->name));
                $flashBag->add('smtc_success', sprintf('Edad: %s', $dog->age));
                $flashBag->add('smtc_success', sprintf('Peso: %s', $dog->weight));
                $flashBag->add('smtc_success', sprintf('Raza: %s', $dog->breed));

                return $this->redirect($this->generateUrl('examples_virtual_forms_dog_create'));
            }
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/forms/virtual/bird/new", name="examples_virtual_forms_bird_create")
     * @Template("MainBundle:Example\VirtualForms:new_bird.html.twig")
     */
    public function birdNewAction(Request $request)
    {
        $bird = new Bird();

        $form = $this->createForm(new BirdType(), $bird);

        if ($request->isMethod("POST")) {
            $form->bind($request);

            if ($form->isValid()) {

                $flashBag = $this->get('session')->getFlashBag();
                $flashBag->add('smtc_success', 'Se ha creado un pájaro:');
                $flashBag->add('smtc_success', sprintf('Nombre: %s', $bird->name));
                $flashBag->add('smtc_success', sprintf('Edad: %s', $bird->age));
                $flashBag->add('smtc_success', sprintf('Peso: %s', $bird->weight));
                $flashBag->add('smtc_success', sprintf('Puede volar?: %s', $bird->canFly ? 'Sí' : 'No'));

                return $this->redirect($this->generateUrl('examples_virtual_forms_bird_create'));
            }
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/forms/virtual/fish/new", name="examples_virtual_forms_fish_create")
     * @Template("MainBundle:Example\VirtualForms:new_fish.html.twig")
     */
    public function fishNewAction(Request $request)
    {
        $fish = new Fish();

        $form = $this->createForm(new FishType(), $fish);

        if ($request->isMethod("POST")) {
            $form->bind($request);

            if ($form->isValid()) {

                $flashBag = $this->get('session')->getFlashBag();
                $flashBag->add('smtc_success', 'Se ha creado un pez:');
                $flashBag->add('smtc_success', sprintf('Nombre: %s', $fish->name));
                $flashBag->add('smtc_success', sprintf('Edad: %s', $fish->age));
                $flashBag->add('smtc_success', sprintf('Peso: %s', $fish->weight));
                $flashBag->add('smtc_success', sprintf('Número de aletas: %s', $fish->finsNumber));

                return $this->redirect($this->generateUrl('examples_virtual_forms_fish_create'));
            }
        }

        return array(
            'form' => $form->createView()
        );
    }
}
