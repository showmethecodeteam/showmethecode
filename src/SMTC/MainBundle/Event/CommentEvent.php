<?php

namespace SMTC\MainBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use SMTC\MainBundle\Model\Comment;
use Symfony\Component\HttpFoundation\Request;

class CommentEvent extends Event
{
    private $comment;
    private $request;

    public function __construct(Request $request, Comment $comment)
    {
        $this->comment = $comment;
        $this->request = $request;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function getComment()
    {
        return $this->comment;
    }
}
