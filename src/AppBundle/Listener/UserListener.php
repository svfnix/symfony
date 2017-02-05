<?php
namespace AppBundle\Listener;

use AppBundle\Entity\Notification;
use AppBundle\Event\BulkEvent;
use AppBundle\Event\MessageEvent;
use AppBundle\Event\NotificationEvent;
use AppBundle\Event\UserEvent;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Pagination\Paginator;

class UserListener
{
    private $_em;

    /**
     * UserListener constructor.
     * @param EntityManager $_em
     */
    function __construct(EntityManager $_em)
    {
        $this->_em = $_em;
    }

    /**
     * @param UserEvent $event
     */
    function onUserSync(UserEvent $event)
    {
        $repo = $this->_em->getRepository('AppBundle:User');
        $repo->sync($event->getUser());
    }

    /**
     * @param MessageEvent $event
     */
    function onMessageSent(MessageEvent $event)
    {
        $user = $event->getMessage()->getReceiver();
        $repo = $this->_em->getRepository('AppBundle:User');
        $repo->sync($user);
    }

    /**
     * @param MessageEvent $event
     */
    function onMessageRead(MessageEvent $event)
    {
        $user = $event->getMessage()->getReceiver();
        $repo = $this->_em->getRepository('AppBundle:User');
        $repo->sync($user);
    }

    /**
     * @param NotificationEvent $event
     */
    function onNotificationSent(NotificationEvent $event)
    {
        $user = $event->getNotification()->getReceiver();
        $repo = $this->_em->getRepository('AppBundle:User');
        $repo->sync($user);
    }
}