<?php

namespace SMTC\MainBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use SMTC\MainBundle\Event\CommentEvent;
use SMTC\MainBundle\CommentEvents;

class CommentBannedWordsSubscriber implements EventSubscriberInterface
{
    private $bannedWords;

    public function __construct($bannedWords = array())
    {
        $this->bannedWords = $bannedWords;
    }

    public static function getSubscribedEvents()
    {
        return array(
            CommentEvents::SUBMITTED => 'onCommentSubmitted'
        );
    }

    public function onCommentSubmitted(CommentEvent $event)
    {
        $comment = $event->getComment();

        foreach ($this->bannedWords as $bannedWord) {
            if (in_array($bannedWord, explode(" ", $comment->message))) {
                $comment->approved = false;
                $event->stopPropagation();

                return;
            }
        }
    }
}
