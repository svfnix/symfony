<?php
namespace AppBundle\Event;

use AppBundle\Entity\Message;
use AppBundle\Entity\User;
use Symfony\Component\EventDispatcher\Event;

class UserEvent extends Event
{
    private $user;

    /**
     * UserEvent constructor.
     * @param User $user
     */
    function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    function getUser(){
        return $this->user;
    }
}