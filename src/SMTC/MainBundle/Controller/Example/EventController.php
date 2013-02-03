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

                if ($commentEvent->isPropagationStopped()) {
                    $this->addCommentToFlashBag('smtc_error', 'No se ha podido crear el comentario', $comment);
                } else {
                    $this->addCommentToFlashBag('smtc_success', 'Se ha creado un comentario', $comment);
                }

                return $this->redirect($this->generateUrl('examples_events_comment'));
            }
        }

        return array(
            'form' => $form->createView()
        );
    }

    private function addCommentToFlashBag($flashKey, $title, $comment)
    {
        $flashBag = $this->get('session')->getFlashBag();

        $flashBag->add($flashKey, $title);
        $flashBag->add($flashKey, sprintf('Username: %s', $comment->username));
        $flashBag->add($flashKey, sprintf('Email: %s', $comment->email));
        $flashBag->add($flashKey, sprintf('Mensaje: %s', $comment->message));
        $flashBag->add($flashKey, sprintf('IP: %s', $comment->ip));
        $flashBag->add($flashKey, sprintf('Aprobado: %s', $comment->approved ? 'Sí' : 'No'));
        $flashBag->add($flashKey, sprintf('Notificado: %s', $comment->notified ? 'Sí' : 'No'));
    }
}
