<?php

namespace SMTC\MainBundle;

final class CommentEvents
{
    /**
     * This event occurs when a comment is submitted
     *
     * The event listener receives an
     * SMTC\MainBundle\Event\CommentEvent instance.
     *
     * @var string
     */
    const SUBMITTED = 'comment.submitted';
}
