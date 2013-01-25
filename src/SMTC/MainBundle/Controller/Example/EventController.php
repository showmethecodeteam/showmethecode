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
                $this->container->get('event_dispatcher')->dispatch(CommentEvents::SUBMITTED, $commentEvent);

                $flashBag = $this->get('session')->getFlashBag();
                $flashBag->add('smtc_success', 'Se ha creado un comentario:');
                $flashBag->add('smtc_success', sprintf('Username: %s', $comment->username));
                $flashBag->add('smtc_success', sprintf('Mensaje: %s', $comment->message));
                $flashBag->add('smtc_success', sprintf('IP: %s', $comment->ip));

                return $this->redirect($this->generateUrl('examples_events_comment'));
            }
        }

        return array(
            'form' => $form->createView()
        );
    }
}
