<?php
namespace AppBundle\Event;

use AppBundle\Entity\Notification;
use Symfony\Component\EventDispatcher\Event;

class BulkEvent extends Event
{
    private $data;

    /**
     * NotificationEvent constructor.
     * @param array $data
     */
    function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    function getData(){
        return $this->data;
    }
}