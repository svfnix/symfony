<?php
namespace AppBundle\Event;

use AppBundle\Entity\Notification;
use Symfony\Component\EventDispatcher\Event;

class NotificationEvent extends Event
{
    private $notification;

    /**
     * NotificationEvent constructor.
     * @param Notification $notification
     */
    function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    /**
     * @return Notification
     */
    function getNotification(){
        return $this->notification;
    }
}