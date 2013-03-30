<?php

namespace SMTC\MainBundle\EventListener;

use SMTC\MainBundle\Event\CommentEvent;

class CommentIpListener
{
    public function onCommentSubmitted(CommentEvent $event)
    {
        $comment = $event->getComment();
        $request = $event->getRequest();
        $comment->ip = $request->getClientIp();
    }
}
