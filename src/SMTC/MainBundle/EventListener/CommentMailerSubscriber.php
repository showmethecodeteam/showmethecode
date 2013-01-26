<?php

namespace SMTC\MainBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use SMTC\MainBundle\Event\CommentEvent;
use SMTC\MainBundle\CommentEvents;

class CommentMailerSubscriber implements EventSubscriberInterface
{
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents()
    {
        return array(
            CommentEvents::SUBMITTED => array('onCommentSubmitted', -5)
        );
    }

    public function onCommentSubmitted(CommentEvent $event)
    {
        $comment = $event->getComment();

        // Send to the comment's author a notification

        $comment->notified = true;
    }
}
