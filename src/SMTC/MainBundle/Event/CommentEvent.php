<?php

namespace SMTC\MainBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use SMTC\MainBundle\Model\Comment;

class CommentEvent extends Event
{
    private $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function getComment()
    {
        return $this->comment;
    }
}