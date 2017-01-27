<?php
namespace AppBundle\Event;

use AppBundle\Entity\Message;
use Symfony\Component\EventDispatcher\Event;

class MessageEvent extends Event
{
    private $message;

    /**
     * MessageEvent constructor.
     * @param Message $message
     */
    function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * @return Message
     */
    function getMessage(){
        return $this->message;
    }
}