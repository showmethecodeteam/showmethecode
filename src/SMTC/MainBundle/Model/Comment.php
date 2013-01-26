<?php

namespace SMTC\MainBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;

class Comment
{
    /**
     * @Assert\NotBlank()
     */
    public $username;

    /**
     * @Assert\Email()
     */
    public $email;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min = 6,
     *     max = 300
     * )
     */
    public $message;

    public $ip;

    public $approved = true;

    public $notified = false;
}
