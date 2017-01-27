<?php
namespace AppBundle\Listener;

use AppBundle\Event\MessageEvent;
use AppBundle\Event\UserEvent;
use Doctrine\ORM\EntityManager;

class UserListener
{
    private $em;

    /**
     * UserListener constructor.
     * @param EntityManager $em
     */
    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param UserEvent $event
     */
    function updateNotificationCount(UserEvent $event)
    {
        $user = $event->getUser();
        $repo = $this->em->getRepository('AppBundle:Notification');
        $notification_count =
            $repo
                ->createQueryBuilder('n')
                ->select('count(n.id)')
                ->where('n.status = unseen')
                ->andWhere('n.receiver = :id')
                ->setParameter('id', $user->getId())
                ->getQuery()
                ->getSingleScalarResult();

        $user->setMetaMessageCount($notification_count);
        $this->em->merge($user);
        $this->em->flush();
    }

    /**
     * @param MessageEvent $event
     */
    function updateMessageCount(MessageEvent $event)
    {
        $user = $event->getMessage()->getReceiver();
        $repo = $this->em->getRepository('AppBundle:Message');
        $messages_count =
            $repo
                ->createQueryBuilder('m')
                ->select('count(m.id)')
                ->where('m.status = unread')
                ->andWhere('m.receiver = :id')
                ->setParameter('id', $user->getId())
                ->getQuery()
                ->getSingleScalarResult();

        $user->setMetaMessageCount($messages_count);
        $this->em->merge($user);
        $this->em->flush();
    }
}