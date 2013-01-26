<?php

namespace SMTC\MainBundle\EventListener;

use Symfony\Component\HttpFoundation\Request;
use SMTC\MainBundle\Event\CommentEvent;

class CommentIpListener
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function onCommentSubmitted(CommentEvent $event)
    {
        $comment = $event->getComment();
        $comment->ip = $this->request->getClientIp();
    }
}