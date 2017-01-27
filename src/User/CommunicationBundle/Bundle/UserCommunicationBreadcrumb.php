<?php
namespace User\CommunicationBundle\Bundle;

use AppBundle\Entity\Message;
use AppBundle\Entity\Notification;
use AppBundle\Helper\Breadcrumb;
use AppBundle\Helper\BreadcrumbWrapper;

class UserCommunicationBreadcrumb extends BreadcrumbWrapper
{
    private $router = null;

    /**
     * UserSettingBreadcrumb constructor.
     * @param $container
     */
    function __construct($container)
    {
        $this->router = $container->get('router');

        $this->base('اطلاع رسانی و پشتیبانی');
    }

    /**
     * @return Breadcrumb
     */
    public function messageIndex()
    {
        return $this->add('پیام های دریافتی', $this->router->generate('user_communication_message'));
    }

    /**
     * @param Message $message
     * @return Breadcrumb
     */
    public function messageRead(Message $message)
    {
        return $this->messageIndex()->add($message->getTitle(), $this->router->generate('user_communication_message_read', [
            'id' => $message->getId()
        ]));
    }

    /**
     * @return Breadcrumb
     */
    public function notificationIndex()
    {
        return $this->add('اطلاعیه های دریافتی', $this->router->generate('user_communication_notification'));
    }
}