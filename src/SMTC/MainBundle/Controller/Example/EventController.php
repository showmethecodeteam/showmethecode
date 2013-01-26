<?php

namespace SMTC\MainBundle\Controller\Example;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SMTC\MainBundle\Model\Comment;
use SMTC\MainBundle\Form\Type\CommentType;
use SMTC\MainBundle\CommentEvents;
use SMTC\MainBundle\Event\CommentEvent;

class EventController extends Controller
{
    /**
     * @Route("/evento", name="examples_events")
     * @Template()
     */
    public function eventsAction()
    {
        return array();
    }

    /**
     * @Route("/evento/comment", name="examples_events_comment")
     * @Template()
     */
    public function commentEventAction()
    {
        $comment = new Comment();
        $form = $this->createForm(new CommentType(), $comment);

        $request = $this->getRequest();

        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {

                // do amazing things

                // Dispatch Event
                $commentEvent = new CommentEvent($comment);
                $commentEvent = $this->container->get('event_dispatcher')->dispatch(CommentEvents::SUBMITTED, $commentEvent);

                $flashBag = $this->get('session')->getFlashBag();

                if ($commentEvent->isPropagationStopped()) {
                    $flashBag->add('smtc_error', 'No se ha podido crear el comentario:');
                    $flashBag->add('smtc_error', sprintf('Username: %s', $comment->username));
                    $flashBag->add('smtc_error', sprintf('Email: %s', $comment->email));
                    $flashBag->add('smtc_error', sprintf('Mensaje: %s', $comment->message));
                    $flashBag->add('smtc_error', sprintf('IP: %s', $comment->ip));
                    $flashBag->add('smtc_error', sprintf('Aprobado: %s', $comment->approved ? 'Sí' : 'No'));
                    $flashBag->add('smtc_error', sprintf('Notificado: %s', $comment->notified ? 'Sí' : 'No'));
                } else {
                    $flashBag->add('smtc_success', 'Se ha creado un comentario:');
                    $flashBag->add('smtc_success', sprintf('Username: %s', $comment->username));
                    $flashBag->add('smtc_success', sprintf('Email: %s', $comment->email));
                    $flashBag->add('smtc_success', sprintf('Mensaje: %s', $comment->message));
                    $flashBag->add('smtc_success', sprintf('IP: %s', $comment->ip));
                    $flashBag->add('smtc_success', sprintf('Aprobado: %s', $comment->approved ? 'Sí' : 'No'));
                    $flashBag->add('smtc_success', sprintf('Notificado: %s', $comment->notified ? 'Sí' : 'No'));
                }

                return $this->redirect($this->generateUrl('examples_events_comment'));
            }
        }

        return array(
            'form' => $form->createView()
        );
    }
}
