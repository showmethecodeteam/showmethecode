<?php

namespace SMTC\MainBundle\Controller\Example;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use SMTC\MainBundle\Form\Type\TaskType;

class FormEmptyDataController extends Controller
{
    /**
     * @Route("/form/empty_data", name="examples_form_empty_data")
     * @Template()
     */
    public function emptyDataAction(Request $request)
    {
        return array();
    }

    /**
     * @Route("/form/empty_data/new-task", name="examples_form_empty_data_new_task")
     * @Template()
     */
    public function newTaskAction(Request $request)
    {
        $form = $this->createForm(new TaskType());

        $form->handleRequest($request);

        if ($form->isValid()) {

            $task = $form->getData();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('smtc_success', sprintf('Se ha creado el objecto -> %s', $task->render()));

            return $this->redirect($this->generateUrl('examples_form_empty_data_new_task'));
        }

        return array(
            'form'   => $form->createView(),
        );
    }
}
