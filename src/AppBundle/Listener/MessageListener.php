<?php
namespace AppBundle\Listener;

use AppBundle\Entity\Message;
use AppBundle\Event\MessageEvent;
use Doctrine\ORM\EntityManager;

class MessageListener
{
    private $em;

    /**
     * MessageListener constructor.
     * @param EntityManager $em
     */
    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param MessageEvent $event
     */
    function onMessageRead(MessageEvent $event)
    {
        $message = $event->getMessage();
        $message->setStatus(Message::STATUS_READ);
        $message->setUpdatedAt();

        $this->em->merge($message);
        $this->em->flush();
    }
}