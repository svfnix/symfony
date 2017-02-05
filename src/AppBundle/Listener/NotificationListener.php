<?php
namespace AppBundle\Listener;

use AppBundle\Entity\Message;
use AppBundle\Entity\Notification;
use AppBundle\Event\BulkEvent;
use AppBundle\Event\MessageEvent;
use AppBundle\Event\NotificationEvent;
use Doctrine\ORM\EntityManager;

class NotificationListener
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
     * @param NotificationEvent $event
     */
    function onNotificationSeen(NotificationEvent $event)
    {
        $notification = $event->getNotification();
        $notification->setStatus(Notification::STATUS_SEEN);
        $notification->setUpdatedAt();

        $this->em->merge($notification);
        $this->em->flush();
    }

    /**
     * @param BulkEvent $events
     */
    function onNotificationSeenBulk(BulkEvent $events)
    {
        $ids = [];
        foreach ($events->getData() as $event){
            if($event->getStatus() == Notification::STATUS_UNSEEN){
                $ids[] = $event->getId();
            }
        }

        if(count($ids)){
            $qb = $this->em->createQueryBuilder();
            $repo = $this->em->getRepository('AppBundle:Notification');
            $repo
                ->createQueryBuilder('n')
                ->update()
                ->set('n.status', $qb->expr()->literal(Notification::STATUS_SEEN))
                ->set('n.updatedAt', $qb->expr()->literal((new \DateTime())->format('Y-m-d H:i:s')))
                ->where('n.id IN(:ids)')
                ->setParameter('ids', array_values($ids))
                ->getQuery()
                ->execute();
        }
    }
}